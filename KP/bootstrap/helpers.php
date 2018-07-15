<?php


function responseJson($data)
{
    $res = new stdClass();
    $res->code = $data['msg'];
    $res->data = $data['data'];
    $res->message = isset($data['message']) ? $data['message'] : '';
    return response()->json($res);
}


function validateData($action)
{
    try {
        return [
            'msg' => config('code.success'),
            'data' => $action,
            "message" => 'success'
        ];
    } catch (Exception $e) {
        return [
            'msg' => config('code.error'),
            'data' => $e,
            "message" => 'error'
        ];
    }
}

function ddJson($data){
    return response()->json($data);
}


