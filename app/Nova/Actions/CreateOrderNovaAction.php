<?php

namespace App\Nova\Actions;

use App\Jobs\ProcessOrderCreationJob;
use App\Services\Pdf\PdfServiceInterface;
use Carbon\Carbon;
use Datomatic\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreateOrderNovaAction extends DetachedAction
{
    use InteractsWithQueue,
        Queueable;

    protected PdfServiceInterface $pdfService;

    public $name = 'Create Orders';

    public $confirmText = 'Please select the date of the order:';

    public $confirmButtonText = 'Confirm';


    public function __construct()
    {
        $this->pdfService = app(PdfServiceInterface::class);
    }

    public function handle(ActionFields $fields)
    {
        $orderDate = Carbon::parse($fields->get('order_date'));

        ProcessOrderCreationJob::dispatch($orderDate, $this->pdfService);

        return DetachedAction::message('Order creation has been queued.');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Date::make('Date:', 'order_date')
                ->rules('required', 'date'),
        ];
    }

}
