<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Appstract\Options\Option;
use Illuminate\Support\Facades\Log;

class OptionController extends Controller
{
    /**
     * @var Option
     */
    private $option;

    /**
     * OptionController constructor.
     * @param Option $option
     */
    public function __construct(Option $option)
    {
        $this->option = $option;
    }

    /**
     * @return Factory|View
     */
    public function print()
    {
        $option = Option::select('key', 'value')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['key'] => $item['value']];
            });
        return view('backend.option.print', compact('option'));
    }

    /**
     * @return Factory|View
     */
    public function cost()
    {
        $option = Option::select('key', 'value')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['key'] => $item['value']];
            });
        return view('backend.option.cost', compact('option'));
    }

    /**
     * @return Factory|View
     */
    public function selfLegalEntities()
    {
        $options['fop'] = json_decode($this->option->get('FOP'), true);
        $options['tov'] = json_decode($this->option->get('TOV'), true);

        return view('backend.option.self-legal-entities', [
            'options' => $options
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->except('_method', '_token');
        try {
                $combinedCostPrinting = array_combine(array_map(function ($value) {
                    return intval($value);
                }, $data['speed_index_keys']), array_map(function ($value) {
                    return (float) $value;
                }, $data['speed_index_values']));

                $this->option->set('speed_index', json_encode($combinedCostPrinting));
                $this->option->set('euro_currency', $data["euro_currency"]);


            return redirect()->back()->withFlashSuccess(__('alerts.backend.options.updated'));
        } catch (\Exception $exception) {
            return redirect()->back()->withFlashDanger(__('alerts.backend.options.not_updated'));
        }
    }
}
