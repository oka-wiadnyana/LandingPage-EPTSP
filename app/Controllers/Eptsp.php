<?php

namespace App\Controllers;

class Eptsp extends BaseController
{


    // public function __construct()
    // {
    //     $this->modelPenelitian = new ModelPenelitian();
    // }



    public function index()
    {

        try {
            $client = \Config\Services::curlrequest();
            $data_corona = $client->send('GET', 'https://api.kawalcorona.com/indonesia/', ['verify' => false]);
            $data_covid = json_decode($data_corona->getBody(), true);


            $data = [

                'title' => 'EPTSP PN Bangli',
                'positif' => $data_covid[0]['positif'],
                'sembuh' => $data_covid[0]['sembuh'],
                'meninggal' => $data_covid[0]['meninggal'],
            ];
        } catch (\Exception $e) {
            $client = \Config\Services::curlrequest();
            $dataapi = $client->request('GET', 'https://covid19.mathdro.id/api/countries/indonesia', ['verify' => false]);
            $body = json_decode($dataapi->getBody(), true);
            $data = [
                'positif' => $body['confirmed']['value'],
                'sembuh' => $body['recovered']['value'],
                'meninggal' => $body['deaths']['value'],

            ];
        }


        return view('beranda', $data);
    }


    public function modal_telegram()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                view('modal-telegram')
            ];
            echo json_encode($msg);
        } else {
            'Forbidden';
        }
    }
}
