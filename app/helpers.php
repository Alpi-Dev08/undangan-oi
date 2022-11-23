<?php

    use App\Core\Adapters\Theme;
    use App\Core\Adapters\Util;
    use App\Models\Klinik\Anamnesis;
use App\Models\Klinik\Physical;
use App\Models\Klinik\Service;
    use App\Models\Klinik\Transaction;
    use App\Models\Klinik\TransactionDetail;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Builder;

    if (!function_exists('get_svg_icon')) {
        function get_svg_icon($path, $class = null, $svgClass = null)
        {
            if (strpos($path, 'media') === false) {
                $path = theme()->getMediaUrlPath() . $path;
            }

            $file_path = public_path($path);

            if (!file_exists($file_path)) {
                return '';
            }

            $svg_content = file_get_contents($file_path);

            if (empty($svg_content)) {
                return '';
            }

            $dom = new DOMDocument();
            $dom->loadXML($svg_content);

            // remove unwanted comments
            $xpath = new DOMXPath($dom);
            foreach ($xpath->query('//comment()') as $comment) {
                $comment->parentNode->removeChild($comment);
            }

            // add class to svg
            if (!empty($svgClass)) {
                foreach ($dom->getElementsByTagName('svg') as $element) {
                    $element->setAttribute('class', $svgClass);
                }
            }

            // remove unwanted tags
            $title = $dom->getElementsByTagName('title');
            if ($title['length']) {
                $dom->documentElement->removeChild($title[0]);
            }
            $desc = $dom->getElementsByTagName('desc');
            if ($desc['length']) {
                $dom->documentElement->removeChild($desc[0]);
            }
            $defs = $dom->getElementsByTagName('defs');
            if ($defs['length']) {
                $dom->documentElement->removeChild($defs[0]);
            }

            // remove unwanted id attribute in g tag
            $g = $dom->getElementsByTagName('g');
            foreach ($g as $el) {
                $el->removeAttribute('id');
            }
            $mask = $dom->getElementsByTagName('mask');
            foreach ($mask as $el) {
                $el->removeAttribute('id');
            }
            $rect = $dom->getElementsByTagName('rect');
            foreach ($rect as $el) {
                $el->removeAttribute('id');
            }
            $xpath = $dom->getElementsByTagName('path');
            foreach ($xpath as $el) {
                $el->removeAttribute('id');
            }
            $circle = $dom->getElementsByTagName('circle');
            foreach ($circle as $el) {
                $el->removeAttribute('id');
            }
            $use = $dom->getElementsByTagName('use');
            foreach ($use as $el) {
                $el->removeAttribute('id');
            }
            $polygon = $dom->getElementsByTagName('polygon');
            foreach ($polygon as $el) {
                $el->removeAttribute('id');
            }
            $ellipse = $dom->getElementsByTagName('ellipse');
            foreach ($ellipse as $el) {
                $el->removeAttribute('id');
            }

            $string = $dom->saveXML($dom->documentElement);

            // remove empty lines
            $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

            $cls = ['svg-icon'];

            if (!empty($class)) {
                $cls = array_merge($cls, explode(' ', $class));
            }

            $asd = explode('/media/', $path);
            if (isset($asd[1])) {
                $path = 'assets/media/' . $asd[1];
            }

            $output = "<!--begin::Svg Icon | path: $path-->\n";
            $output .= '<span class="' . implode(' ', $cls) . '">' . $string . '</span>';
            $output .= "\n<!--end::Svg Icon-->";

            return $output;
        }
    }

    if (!function_exists('theme')) {
        /**
         * Get the instance of Theme class core
         *
         * @return \App\Core\Adapters\Theme|\Illuminate\Contracts\Foundation\Application|mixed
         */
        function theme()
        {
            return app(Theme::class);
        }
    }

    if (!function_exists('util')) {
        /**
         * Get the instance of Util class core
         *
         * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
         */
        function util()
        {
            return app(Util::class);
        }
    }

    if (!function_exists('bootstrap')) {
        /**
         * Get the instance of Util class core
         *
         * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
         * @throws Throwable
         */
        function bootstrap()
        {
            $demo      = ucwords(theme()->getDemo());
            $bootstrap = "\App\Core\Bootstraps\Bootstrap$demo";

            if (!class_exists($bootstrap)) {
                abort(404, 'Demo has not been set or ' . $bootstrap . ' file is not found.');
            }

            return app($bootstrap);
        }
    }

    if (!function_exists('assetCustom')) {
        /**
         * Get the asset path of RTL if this is an RTL request
         *
         * @param      $path
         * @param null $secure
         *
         * @return string
         */
        function assetCustom($path)
        {
            // Include rtl css file
            if (isRTL()) {
                return asset(theme()->getDemo() . '/' . dirname($path) . '/' . basename($path, '.css') . '.rtl.css');
            }

            // Include dark style css file
            if (theme()->isDarkModeEnabled() && theme()->getCurrentMode() !== 'light') {
                $darkPath = str_replace('.bundle', '.' . theme()->getCurrentMode() . '.bundle', $path);
                if (file_exists(public_path(theme()->getDemo() . '/' . $darkPath))) {
                    return asset(theme()->getDemo() . '/' . $darkPath);
                }
            }

            // Include default css file
            return asset(theme()->getDemo() . '/' . $path);
        }
    }

    if (!function_exists('isRTL')) {
        /**
         * Check if the request has RTL param
         *
         * @return bool
         */
        function isRTL()
        {
            return (bool) request()->input('rtl');
        }
    }

    if (!function_exists('preloadCss')) {
        /**
         * Preload CSS file
         *
         * @return bool
         */
        function preloadCss($url)
        {
            return '<link rel="preload" href="' . $url . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" type="text/css"><noscript><link rel="stylesheet" href="' . $url . '"></noscript>';
        }
    }

    if (!function_exists('services')) {
        /**
         * Check if the request has RTL param
         */
        function services($id)
        {
            $services = Service::where('service_category_id', $id)->get();

            return $services;
        }
    }

    if (!function_exists('anamnesis')) {
        /**
         * Check if the request has RTL param
         */
        function anamnesis($id)
        {
            $anamnesis = Anamnesis::where('anamnesis_category_id', $id)->get();

            return $anamnesis;
        }
    }

    if (!function_exists('getAnamnesisCategory')) {
        /**
         * Check if the request has RTL param
         */
        function getAnamnesisCategory($id)
        {
            $category = \App\Models\Klinik\AnamnesisCategory::find($id);

            return $category;
        }
    }

    if (!function_exists('getAnamnesis')) {
        /**
         * Check if the request has RTL param
         */
        function getAnamnesis($id)
        {
            $anamnesis = Anamnesis::find($id);

            return $anamnesis;
        }
    }

if (!function_exists('physicals')) {
    /**
     * Check if the request has RTL param
     */
    function physicals($id)
    {
        $physicals = Physical::where('physical_category_id', $id)->get();

        return $physicals;
    }
}

    if (!function_exists('getPhysicalsCategory')) {
        /**
         * Check if the request has RTL param
         */
        function getPhysicalsCategory($id)
        {
            $category = \App\Models\Klinik\PhysicalCategory::find($id);

            return $category;
        }
    }

    if (!function_exists('getPhysicals')) {
        /**
         * Check if the request has RTL param
         */
        function getPhysicals($id)
        {
            $anamnesis = Physical::find($id);

            return $anamnesis;
        }
    }

    if (!function_exists('service_examination')) {
        /**
         * Check if the request has RTL param
         */
        function service_examination($id)
        {
            $transaction = Transaction::where('examination_id', $id)->first();
            $transaction_detail = TransactionDetail::with('service','service.category')->where('transaction_id', $transaction->id)->whereHas('service.category', function(Builder $query){
                $query->where('is_global', 0);
            })->get();

            return $transaction_detail;
        }
    }


    if(!function_exists('cekVitalityExamination')){
        function cekVitalityExamination($id){
            $vit = \App\Models\Klinik\VitalityExamination::where('examination_id', $id)->first();

            if($vit)
                return true;
            return false;
        }
    }
