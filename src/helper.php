<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

if (!function_exists('siga_path')){

    function siga_path($path=""){

        return sprintf("%s/%s",__DIR__, $path);
    }
}

if (! function_exists('tableView')) {
    /**
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder $data
     * @return \SIGA\TableView\TableView
     */
    function tableView($data)
    {
        return new SIGA\TableView\TableView($data);
    }
}

if (! function_exists('tableViewColumns')) {
    /**
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder $data
     * @return \SIGA\TableView\TableView
     */
    function tableViewColumns($data)
    {
        return new SIGA\TableView\DataViewsColumns($data);
    }
}


if (! function_exists('tableViewForm')) {
    /**
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder $data
     * @return \SIGA\TableView\TableView
     */
    function tableViewForm($data)
    {
        return new SIGA\TableView\TableViewForm($data);
    }
}

if (!function_exists('get_tenant_id')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function get_tenant_id($tenant = 'company_id')
    {
        $tenantId = \SIGA\Tenant\Facades\Tenant::getTenantId($tenant);
        return $tenantId;
    }
}

if (!function_exists('get_tenant')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function get_tenant()
    {
        return \SIGA\Company::find(get_tenant_id());
    }
}


if (!function_exists('date_carbom_format')) {

    function date_carbom_format($date, $format = "d/m/Y H:i:s")
    {

        $date = explode(" ", str_replace(["-", "/", ":"], " ", $date));

        if (!isset($date[0])) {
            $date[0] = null;
        }
        if (!isset($date[1])) {
            $date[1] = null;
        }
        if (!isset($date[2])) {
            $date[2] = null;
        }
        if (!isset($date[3])) {
            $date[3] = null;
        }
        if (!isset($date[4])) {
            $date[4] = null;
        }
        if (!isset($date[5])) {
            $date[5] = null;
        }
        list($y, $m, $d, $h, $i, $s) = $date;

        //$carbon = \Carbon\Carbon::now();
        $carbon = \Illuminate\Support\Facades\Date::now();
        $carbon->locale('pt');
        if (strlen($date[0]) == 4) {
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toDateTimeLocalString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toDayDateTimeString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toLongDateString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toFullDateString().PHP_EOL;
            //
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toShortTimeString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toMediumTimeString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toLongTimeString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toFullTimeString().PHP_EOL;
            //
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toShortDatetimeString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toMediumDatetimeString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toLongDatetimeString().PHP_EOL;
            //            echo  $carbon->create($y,$m,$d,$h,$i,$s)->toFullDatetimeString().PHP_EOL;
            return $carbon->create($y, $m, $d, $h, $i, $s);
        }
        if ($y && $m && $d) {
            return $carbon->create($d, $m, $y, $h, $i, $s);
        }
        return $carbon->create(null, null, null, null, null, null);
    }
}


if (!function_exists('check_status')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function check_status($status, $options = [
        'published' => "success", 'draft' => "warning", 'deleted' => "danger"
    ])
    {
        if (isset($options[$status]))
            return $options[$status];


        return "info";
    }
}

if (!function_exists('set_header_order')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function set_header_order($endpoint, $order= "desc", $column="id")
    {

        return route(sprintf("admin.%s.index", $endpoint), array_merge(request()->query(), [
            'order' => $order == "desc"?"asc":"desc",
            'column' => $column
        ]));
    }
}


if (!function_exists('form')) {

    function form(\SIGA\TableView\TableViewForm $form, array $options = [])
    {
        return $form->renderForm($options);
    }

}
if (!function_exists('form_start')) {

    function form_start( array $options = [])
    {
        return view($options['open'],$options);
    }

}

if (!function_exists('form_end')) {

    function form_end( array $options = [])
    {
        return view($options['close'],$options);
    }

}
