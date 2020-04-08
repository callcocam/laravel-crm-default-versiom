<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use SIGA\TraitTable;
use SIGA\User;

class AbstractController extends Controller
{

    protected $model;
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
            return  back()->withErrors("Not Authorized");
        }

        if(is_string($this->model)){
            return app($this->model)->findAll($this->templateList);
        }


        return view("admin.index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        if (Gate::denies(Route::currentRouteName())) {
            return  back()->withErrors("Not Authorized");
        }
        $tableView=[];

        if(is_string($this->model))
            $tableView = app($this->model)->create($this->templateCreate);

        return $tableView;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function save($request, $id=null)
    {

        if (Gate::denies(Route::currentRouteName())) {
            return  back()->withErrors("Not Authorized");
        }
        /**
         * @var $formView TraitTable
         */
        $formView = app($this->model);

        if ($request->isMethod("POST"))
        {

            if($formView->createBy($request->post())){

                $this->execEvent($this->eventCreate, $formView->getModel());

                notify()->success($formView->getResult('messages'));

                return redirect()->to($formView->getEdit('api'))->with('success', $formView->getResult('messages'));
            }
            notify()->error($formView->getResult('messages'));

            return back()->withErrors($formView->getResult('messages'))->withInput($request->post());

        }

        if($formView->updateBy($request->post(), $id)){

            $this->execEvent($this->eventUpdate, $formView->getModel());

            notify()->success($formView->getResult('messages'));

            return redirect()->to($formView->getEdit('api'))->with('success', $formView->getResult('messages'));
        }
        notify()->error($formView->getResult('messages'));

        return back()->withErrors($formView->getResult('messages'))->withInput($request->post());

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
            return  back()->withErrors("Not Authorized");
        }
        $tableView=[];

        if(is_string($this->model))
            $tableView = app($this->model)->findShow($id, $this->templateShow);

        return $tableView;
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
            return  back()->withErrors("Not Authorized");
        }
        $tableView=[];
        if(is_string($this->model))
            $tableView = app($this->model)->edit($id, $this->templateEdit);

        return $tableView;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * @var $formView TraitTable
         */
        $formView = app($this->model)->find($id);

        if (Gate::denies(Route::currentRouteName())) {
            return  back()->withErrors("Not Authorized");
        }


        if($formView->deleteBy($formView)){

            $this->execEvent($this->eventDelete, $formView);

            notify()->success($formView->getResult('messages'));

            return redirect()->to($formView->getEdit('api'))->with('success', $formView->getResult('messages'));
        }

        notify()->error($formView->getResult('messages'));

        return back()->withErrors($formView->getResult('messages'));

    }

    protected function execEvent($event, $params= null){

        if($event){

            if($params){

                event(new $event($params));

            }
            else{

                event(new $event);
            }
        }
    }
}
