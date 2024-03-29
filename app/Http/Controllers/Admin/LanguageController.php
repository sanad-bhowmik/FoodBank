<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\LanguageRequest;
use PragmaRX\Countries\Package\Countries;
use App\Http\Controllers\BackendController;


class LanguageController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Language';

        $this->middleware(['permission:language'])->only('index');
        $this->middleware(['permission:language_create'])->only('create', 'store');
        $this->middleware(['permission:language_edit'])->only('edit', 'update');
        $this->middleware(['permission:language_delete'])->only('destroy');
    }
    public function index(Request $request)
    {

        return $this->getLanguage($request);
    }


    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $flag = null;

        $countries = Countries::all();
        foreach ($countries as  $countrie) {
            if (strtolower($countrie['iso_a2']) == strtolower($request->code)) {
                $flag = $countrie['extra']['emoji'];
            }
        }

        $language            = new Language;
        $language->name      = $request->name;
        $language->code      = $request->code;
        $language->flag_icon = $flag;
        $language->status    = $request->status;
        $language->save();
        return redirect()->route('admin.language.index')->withSuccess('Language Create Succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['language']  = Language::findOrFail($id);
        return view('admin.language.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, Language $language)
    {
        $flag = null;
        $countries = Countries::all();
        foreach ($countries as  $countrie) {
            if (strtolower($countrie['iso_a2']) == strtolower($request->code)) {
                $flag = $countrie['extra']['emoji'];
            }
        }

        $language->name      = $request->name;
        $language->code      = $request->code;
        $language->flag_icon = $flag;
        $language->status    = $request->status;
        $language->save();
        return redirect()->route('admin.language.index')->withSuccess('Language Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Language::findOrFail($id)->delete();
        return redirect(route('admin.language.index'))->withSuccess('The Data Deleted Successfully');
    }

    private function getLanguage(Request $request)
    {

        if (request()->ajax()) {

            if ($request->status) {
                $laguages = Language::where('status', $request->status)->get();
            } else {
                $laguages = Language::all();
            }

            $i            = 0;
            return Datatables::of($laguages)
                ->addColumn('action', function ($language) {
                    $retAction = '';

                    if (auth()->user()->can('language_edit')) {
                        $retAction .= '<a href="' . route('admin.language.edit', $language) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('language_delete')) {
                        $retAction .= '<form id="detete-'.$language->id.'"  class="float-left pl-2" action="' . route('admin.language.destroy', $language) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                        '<button type="button" data-id="'.$language->id.'"
                        class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                        <i class="fa fa-trash"></i>
                        </button> </form>';
                    }
                    return $retAction;
                })
                ->editColumn('id', function ($language) use (&$i) {
                    return ++$i;
                })
                ->editColumn('language_name', function ($language) {
                    return $language->name;
                })
                ->editColumn('flag', function ($language) {
                    return $language->flag_icon == null ? '🇬🇧' : $language->flag_icon;
                })
                ->editColumn('code', function ($language) {
                    return strtoupper($language->code);
                })
                ->editColumn('status', function ($language) {
                    $drop = '';
                    $activeStatus = 'Change Status';
                    foreach (trans("statuses") as $key => $status) {
                        if ($language->status == $key) {
                            $activeStatus = $status;
                            $drop .= '';
                        } else {
                            $drop .= '<a class="dropdown-item" href="' . route('admin.language.change-status', [$language->id, $key]) . '">' . $status . '</a>';
                        }
                    }
                    return '<div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                        . $activeStatus
                        . '</button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' . $drop . '</div></div>';
                })
                ->rawColumns(['name', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.language.index', $this->data);
    }

    public function changeStatus($id, $status)
    {
        $language         = Language::findOrFail($id);
        $language->status = $status;
        $language->save();
        return redirect()->route('admin.language.index')->withSuccess('The Status Change successfully!');
    }
}
