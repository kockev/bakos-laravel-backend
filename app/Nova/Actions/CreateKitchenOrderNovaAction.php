<?php

namespace App\Nova\Actions;

use App\Jobs\ProcessKitchenOrderCreationJob;
use App\Services\Pdf\PdfServiceInterface;
use Carbon\Carbon;
use Datomatic\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreateKitchenOrderNovaAction extends DetachedAction
{
    use InteractsWithQueue,
        Queueable;

    protected PdfServiceInterface $pdfService;

    public $name = 'Create Kitchen Order';

    public $confirmText = 'Please select the date of the kitchen order:';

    public $confirmButtonText = 'Yes';

    public function __construct()
    {
        $this->pdfService = app(PdfServiceInterface::class);
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        $orderDate = Carbon::parse($fields->get('order_date'));

        ProcessKitchenOrderCreationJob::dispatch($orderDate, $this->pdfService);

        Action::message(('Kitchen Order creation has been queued.'));
    }

    public function fields(NovaRequest $request)
    {
        return [
            Date::make('Date:', 'order_date')
                ->rules('required', 'date'),
        ];
    }
}
