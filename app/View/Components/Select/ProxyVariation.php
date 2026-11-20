<?php

namespace App\View\Components\Select;

use App\Core\Enums\ProxyStatus;
use App\Models\Proxy;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProxyVariation extends Component
{
    public $proxies;
    public $variations;
    public $selectedProxy;
    public $selectedVariation;
    public $required;

    public function __construct(
        $selectedProxy = null,
        $selectedVariation = null,
        $required = false
    ) {
        $this->selectedProxy = $selectedProxy;
        $this->selectedVariation = $selectedVariation;
        $this->required = $required;

        $this->proxies = Proxy::where('status', ProxyStatus::Available)->get();
        $this->variations = $selectedProxy ? \App\Models\ProxyVariation::with('variation')->where('proxy_id', $selectedProxy)->get() : [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select.proxy-variation');
    }
}
