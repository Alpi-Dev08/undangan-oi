<?php

    use App\Models\SatuSehatLogs;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;

    function generateToken()
    {
        $clientId     = env('CLIENTID_PROD');
        $clientSecret = env('CLIENTSECRET_PROD');
        $url          = env('SATUSEHAT_BASE_URL_PROD') . '/accesstoken?grant_type=client_credentials';
        $url          = $url.env('SATUSEHAT_AUTH_ENDPOINT');

        $data    = [
            'client_id'     => $clientId,
            'client_secret' => $clientSecret
        ];
        $request = Http::asForm()->post($url, $data);

        $response = response()->json([
            "success" => $request->ok(),
            'data'    => $request->object()
        ], $request->status());

        Log::info($response);

        $logs = [
            'service'     => 'auth',
            'url'         => $url,
            'type'        => 'create',
            'messages'    => json_encode($data),
            'response'    => json_encode($request->object()),
            'status'      => $request->status(),
            'description' => 'Generate Token'
        ];

        satu_sehat_logs($logs);
        return $response;
    }

    function satu_sehat_consent($data)
    : bool|string
    {
        $token = generateToken();
        $token = json_decode($token->content());
        $token = $token->data->access_token;
        $url   = env('SATU_SEHAT_CONSENT_URL') . '/Consent';

        $request = Http::withToken($token)->post($url, $data);

        $response = response()->json([
            "success" => $request->ok(),
            'data'    => $request->object()
        ], $request->status());
        Log::info($response);

        $logs = [
            'service'     => 'consent',
            'url'         => $url,
            'type'        => 'create',
            'messages'    => json_encode($data),
            'response'    => json_encode($request->object()),
            'status'      => $request->status(),
            'description' => 'Consent Data'
        ];

        satu_sehat_logs($logs);

        return json_encode($request->object());
    }

    function satu_sehat($type, $service, $data, $id = '')
    {
        $token = generateToken();
        $token = json_decode($token->content());
        $token = $token->data->access_token;
        $url   = env('SATU_SEHAT_URL');

        if ($id) {
            $url = $url . '/' . $service . '/' . $id;
        } else {
            $url = $url . '/' . $service;
        }

        if ($type == 'create') {
            $request = Http::withToken($token)->post($url, $data);
        } else if ($type == 'update') {
            $request = Http::withToken($token)->put($url, $data);
        } else if ($type == 'delete') {
            $request = Http::withToken($token)->delete($url);
        } else {
            $request = Http::withToken($token)->get($url);
        }

        $response = response()->json([
            "success" => $request->ok(),
            'data'    => $request->object()
        ], $request->status());
        Log::info($response);

        $logs = [
            'service'  => $service,
            'url'      => $url,
            'type'     => $type,
            'messages' => json_encode($data),
            'response' => json_encode($request->object()),
            'status'   => $request->status()
        ];

        satu_sehat_logs($logs);

        return json_encode($request->object());
    }

    function satu_sehat_logs($data)
    {
        $logs = new SatuSehatLogs();
        $logs->fill($data);
        $logs->save();
    }


