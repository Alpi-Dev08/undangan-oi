<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;

    function generateToken()
    {
        $clientId     = env('SATU_SEHAT_CLIENT_ID');
        $clientSecret = env('SATU_SEHAT_CLIENT_SECRET');

        $request = Http::asForm()->post(env('SATU_SEHAT_AUTH_URL') . '/accesstoken?grant_type=client_credentials', [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret
        ]);

        $response =  response()->json([
            "success" => $request->ok(),
            'data'    => $request->object()
        ], $request->status());

        Log::info($response);
        return $response;
    }

    function satu_sehat_consent($data): bool|string
    {
        $token    = generateToken();
        $token    = json_decode($token->content());
        $token    = $token->data->access_token;
        $url      = env('SATU_SEHAT_CONSENT_URL').'/Consent';

        $request = Http::withToken($token)->post($url, $data);

        $response = response()->json([
            "success" => $request->ok(),
            'data'    => $request->object()
        ], $request->status());
        Log::info($response);
        return json_encode($request->object());
    }

    function satu_sehat($type,$service,$data,$id='')
    {
        $token    = generateToken();
        $token    = json_decode($token->content());
        $token    = $token->data->access_token;
        $url      = env('SATU_SEHAT_URL');

        if($id){
            $url      = $url . '/' . $service . '/' . $id;
        } else {
            $url      = $url . '/' . $service;
        }

        if($type == 'create'){
            $request = Http::withToken($token)->post($url, $data);
        }elseif($type == 'update'){
            $request = Http::withToken($token)->put($url, $data);
        }elseif($type == 'delete'){
            $request = Http::withToken($token)->delete($url);
        }else{
            $request = Http::withToken($token)->get($url);
        }

        $response = response()->json([
            "success" => $request->ok(),
            'data'    => $request->object()
        ], $request->status());
        Log::info($response);
        return json_encode($request->object());
    }


