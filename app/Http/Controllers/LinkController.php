<?php

namespace App\Http\Controllers;

use App\Link;
use App\Domain;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'sucess' => true,
            'link' => $request->user()->account->links()->with(['domain'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'longLink' => 'required',
            'domain' => 'required',
            'source' => 'required',
        ]);

        // Domain check
        $domain = Domain::whereName(getHost($request->domain))->first();
        if (!$domain) {
            return response()->json([
                'sucess' => false,
                'message' => 'Domain is not exists',
            ]);
        }

        // Link check
        $link = Link::query()->Domain($domain)->Hash(md5($request->longLink))->first();
        if ($link) {
            return response()->json([
                'sucess' => true,
                'message' => 'Link already exists',
                'link' => $link,
            ]);
        }

        // Create new link
        $link = Link::newInstanceFromLongLink($request->longLink, $request->source);
        $link->createdBy()->associate($request->user());

        $link->domain()->associate($domain);
        $link->account()->associate($request->user()->account);

        $link->save();

        return response()->json([
            'sucess' => true,
            'link' => $link,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
