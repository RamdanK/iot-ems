<?php

namespace App\Filament\Widgets;

use App\Models\DeviceStatus;
use App\Services\DeviceMatrixService;
use Filament\Support\RawJs;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DeviceCurrentTrendChart extends ApexChartWidget
{
    protected static ?string $pollingInterval = null;
    protected static ?int $contentHeight = 200; //px

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'device-current-chart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Current Trend';

    public string $deviceId;

    public array $data = [
        'data' => [
            ['name' => 'Current 1', 'data' => []],
            ['name' => 'Current 2', 'data' => []],
        ],
        'labels' => [],
    ];

    public function mount(): void
    {
        if ($this->deviceId) {
            $this->getData();
        }

        parent::mount();
    }

    public function getListeners()
    {
        return [
            "echo-private:device-status-updated.{$this->deviceId},DeviceStatusAccepted" => 'updateData',
        ];
    }

    public function updateData($event)
    {
        $data1 = $event['deviceStatus']['current1'];
        $data2 = $event['deviceStatus']['current2'];
        $date = $event['deviceStatus']['created_at'];

        $data1Stream = $this->data['data'][0]['data'];
        $data2Stream = $this->data['data'][1]['data'];
        $labels = $this->data['labels'];

        if (count($labels) > 100) {
            array_shift($data1Stream);
            array_shift($data2Stream);
            array_shift($labels);
        }

        array_push($data1Stream, $data1);
        array_push($data2Stream, $data2);
        array_push($labels, $date);

        $this->data['data'][0]['data'] = $data1Stream;
        $this->data['data'][1]['data'] = $data2Stream;
        $this->data['labels'] = $labels;

        $this->updateOptions();
    }

    protected function getData(): void
    {
        $data = DeviceMatrixService::getDeviceTrend($this->deviceId, ['created_at', 'current1', 'current2']);
        if ($data->count() > 0) {
            $this->data['data'] = [
                [
                    'name' => 'Current 1',
                    'data' => $data->map(fn(DeviceStatus $value) => (float) $value->current1)->toArray(),
                ],
                [
                    'name' => 'Current 2',
                    'data' => $data->map(fn(DeviceStatus $value) => (float) $value->current2)->toArray(),
                ],
            ];
            $this->data['labels'] = $data->map(fn(DeviceStatus $value) => $value->created_at)->toArray();
        }
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        // dd($this->data);
        return [
            'chart' => [
                'type' => 'line',
                'height' => 200
            ],
            'series' => $this->data['data'],
            'xaxis' => [
                'type' => 'datetime',
                'categories' => $this->data['labels'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                    'datetimeUTC' => false,

                ],
            ],
            'yaxis' => [
                [
                    'labels' => [
                        'style' => [
                            'fontFamily' => 'inherit',
                        ],
                    ],
                    'title' => [
                        'text' => 'Current 1 (A)'
                    ],
                ],
                [
                    'opposite' => true,
                    'labels' => [
                        'style' => [
                            'fontFamily' => 'inherit',
                        ],
                    ],
                    'title' => [
                        'text' => 'Current 2 (A)'
                    ],
                ],
            ],
            'colors' => ['#FF1654', '#247BA0'],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 2
            ],
        ];
    }

    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(<<<'JS'
    {
        chart: {
            toolbar: {
                show: false
            }
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val + ' A'
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + ' A'
                }
            },
            x: {
                format: 'dd MMM yyyy, HH:mm:ss',
            },
        },
        grid:{
            borderColor: '#90A4AE',
            strokeDashArray: 2,
            position: 'back',
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        noData: {
            text: 'No Data Available',
            align: 'center',
            verticalAlign: 'middle',
            offsetX: 0,
            offsetY: 0,
            style: {
                fontFamily: 'inherit'
            }
        }
    }
    JS);
    }
}
