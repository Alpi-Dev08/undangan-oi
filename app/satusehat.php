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

    function satu_sehat($type,$service,$id,$data)
    {
        $token    = generateToken();
        $token    = json_decode($token->content());
        $token    = $token->data->access_token;
        $url      = env('SATU_SEHAT_URL');
        $url      = $url . '/' . $service . '/' . $id;
        $request  = Http::withToken($token)->put($url, $data);
        $response = response()->json([
            "success" => $request->ok(),
            'data'    => $request->object()
        ], $request->status());
        Log::info($response);
    }


