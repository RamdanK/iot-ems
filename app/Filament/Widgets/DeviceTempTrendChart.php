<?php

namespace App\Filament\Widgets;

use App\Models\DeviceStatus;
use App\Services\DeviceMatrixService;
use Filament\Support\RawJs;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DeviceTempTrendChart extends ApexChartWidget
{
    protected static ?string $pollingInterval = null;
    protected static ?int $contentHeight = 200; //px

    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'device-temp-chart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Temperature Level Trend';

    public $deviceId;

    public array $data = [
        'data' => [],
        'labels' => [],
    ];

    public function mount(): void
    {
        $this->getData();

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
        $data1 = $event['deviceStatus']['temp'];
        $date = $event['deviceStatus']['created_at'];

        $this->data['data'][0]['data'][] = $data1;
        $this->data['labels'][] = $date;

        $this->updateOptions();
    }

    protected function getData(): void
    {
        $data = DeviceMatrixService::getDeviceTrend($this->deviceId, ['created_at', 'temp']);
        if ($data->count() > 0) {
            $this->data['data'] = [
                [
                    'name' => 'Temperature',
                    'data' => $data->map(fn (DeviceStatus $value) => (float) $value->temp),
                ],
            ];
            $this->data['labels'] = $data->map(fn (DeviceStatus $value) => $value->created_at);
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
                        'text' => 'Temperature (°C)'
                    ],
                ],
            ],
            'colors' => ['#247BA0'],
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
                    return val + ' °C'
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + ' °C'
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
