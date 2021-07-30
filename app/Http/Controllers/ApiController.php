<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Services\Executors\Factory;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Gets all data
     *
     * @param  \App\Http\Requests\ApiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllData(ApiRequest $request)
    {
        $json = [];

        if (!isset($request->period)) {
            $factory = new Factory();
            $client = $factory->build($request->service_name);

            foreach ($request->game_ids as $id) {
                $json = array_merge($client->getStreams($id), $json);
            }
        } else {
            $query = streams_model()->newQuery();

            if ($request->game_ids) {
                $query->whereIn('game_id', $request->game_ids);
            }

            $json = $query->whereBetween(
                'created_at',
                [$request->period['from'], $request->period['to']]
            )->orderBy('game_id')->get();
        }

        return response()
            ->json($json);
    }

    /**
     * Gets viewers data
     *
     * @param  \App\Http\Requests\ApiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getViewers(ApiRequest $request)
    {
        $json = [];

        if (!isset($request->period)) {
            $factory = new Factory();
            $client = $factory->build($request->service_name);
            foreach ($request->game_ids as $id) {
                $json = array_merge($client->getStreams($id), $json);
            }

            $json = array_map(function ($value) {
                return [
                    'game_id' => $value->game_id,
                    'game_name' => $value->game_name,
                    'stream_id' => $value->id,
                    'viewers' => $value->viewer_count,
                ];

            }, $json);

        } else {
            $query = streams_model()->newQuery()->select(
                ['game_id', 'game_name', 'stream_id', 'viewers']
            );

            if ($request->game_ids) {
                $query->whereIn('game_id', $request->game_ids);
            }

            $json = $query->whereBetween(
                'created_at',
                [$request->period['from'], $request->period['to']]
            )->orderBy('game_id')->get();
        }

        return response()
            ->json($json);
    }
}
