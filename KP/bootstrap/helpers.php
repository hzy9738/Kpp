<?php


function responseJson($data)
{
    $res = new stdClass();
    $res->code = $data['msg'];
    $res->data = $data['data'];
    return response()->json($res);
}


function validateData($action)
{
    try {
        return [
            'msg' => config('code.success'),
            'data' => $action
        ];
    } catch (Exception $e) {
        return [
            'msg' => config('code.error'),
            'data' => $e
        ];
    }
}
