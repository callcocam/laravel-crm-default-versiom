<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class AbstractController extends Controller
{

    protected $model;
    protected $tableView;
    protected $redirectRoute;
    protected $eventCreate;
    protected $eventUpdate;
    protected $eventDelete;
    protected $templateList = "index";
    protected $templateEdit = "edit";
    protected $templateShow = "show";
    protected $templateCreate = "create";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        if (Gate::denies(Route::currentRouteName())) {

            notify()->error("Not Authorized");

            return redirect()->route('restricts');
        }

        if (is_string($this->model)) {
            return app($this->model)->findAll($this->templateList);
        }


        return view("admin.index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies(Route::currentRouteName())) {

            notify()->error("Not Authorized");

            return redirect()->route('restricts');
        }


        if (is_string($this->model))
            $this->tableView = app($this->model)->create($this->templateCreate);

        return $this->tableView;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function save($request, $id = null)
    {

        if (Gate::denies(Route::currentRouteName())) {

            notify()->error("Not Authorized");

            return redirect()->route('restricts');
        }

        $this->tableView = app($this->model);

        if ($request->isMethod("POST")) {

            if ($this->tableView->createBy($request->post())) {

                $this->execEvent($this->eventCreate, $this->tableView->getModel());

                notify()->success($this->tableView->getResult('messages'));

                if ($request->has('redirect')) {

                    return redirect()->route($request->get('redirect'), request()->query())->with('success', $this->tableView->getResult('messages'));
                }
                if ($this->redirectRoute) {

                    return redirect()->route($this->redirectRoute, request()->query())->with('success', $this->tableView->getResult('messages'));
                }

                return redirect()->to($this->tableView->getEdit('api'))->with('success', $this->tableView->getResult('messages'));
            }

            notify()->error($this->tableView->getResult('messages'));

            return back()->withErrors($this->tableView->getResult('messages'))->withInput($request->post());
        }

        if ($this->tableView->updateBy($request->post(), $id)) {

            $this->execEvent($this->eventUpdate, $this->tableView->getModel());

            notify()->success($this->tableView->getResult('messages'));

            if ($request->has('redirect')) {

                return redirect()->route($request->get('redirect'), request()->query())->with('success', $this->tableView->getResult('messages'));
            }

            if ($this->redirectRoute) {

                return redirect()->route($this->redirectRoute, request()->query())->with('success', $this->tableView->getResult('messages'));
            }

            return redirect()->to($this->tableView->getEdit('api'))->with('success', $this->tableView->getResult('messages'));
        }

        notify()->error($this->tableView->getResult('messages'));

        return back()->withErrors($this->tableView->getResult('messages'))->withInput($request->post());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (Gate::denies(Route::currentRouteName())) {

            notify()->error("Not Authorized");

            return redirect()->route('restricts');
        }

        if (is_string($this->model))
            $this->tableView = app($this->model)->findShow($id, $this->templateShow);

        return $this->tableView;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (Gate::denies(Route::currentRouteName())) {

            notify()->error("Not Authorized");

            return redirect()->route('restricts');
        }
        if (is_string($this->model))
            $this->tableView = app($this->model)->edit($id, $this->templateEdit);

        return $this->tableView;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->tableView = app($this->model)->find($id);

        if (Gate::denies(Route::currentRouteName())) {

            notify()->error("Not Authorized");

            return redirect()->route('restricts');
        }


        if ($this->tableView->deleteBy($this->tableView)) {

            $this->execEvent($this->eventDelete, $this->tableView);

            notify()->success($this->tableView->getResult('messages'));

            return redirect()->to($this->tableView->getIndex('api'))->with('success', $this->tableView->getResult('messages'));
        }

        notify()->error($this->tableView->getResult('messages'));

        return back()->withErrors($this->tableView->getResult('messages'));
    }

    protected function execEvent($event, $params = null)
    {

        if ($event) {

            if ($params) {

                event(new $event($params));
            } else {

                event(new $event);
            }
        }
    }
}
