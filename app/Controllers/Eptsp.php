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

        $client = \Config\Services::curlrequest();
        $data_corona = $client->send('GET', 'https://api.kawalcorona.com/indonesia/');
        $data_covid = json_decode($data_corona->getBody(), true);


        $data = [

            'title' => 'EPTSP PN Bangli',
            'positif' => $data_covid[0]['positif'],
            'sembuh' => $data_covid[0]['sembuh'],
            'meninggal' => $data_covid[0]['meninggal'],
        ];

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

    public function download($main_dir, $dir, $file)
    {
        return $this->response->download($main_dir . '/' . $dir . '/' . $file, null);
    }


    public function v_tambah_penelitian()
    {

        $db = db_connect();
        $builder = $db->table('users');
        $data_user = $builder->select('nama,jenis_kelamin,nim,nomor_hp,email,username,universitas,fakultas')->where('username', session()->get('username'))->get()->getRowArray();

        $data = [
            'title' => 'Tambah Penelitian',
            'data_user' => $data_user

        ];
        return view('user/tambah_penelitian', $data);
    }

    public function insert()
    {

        $nama = $this->request->getVar('nama');
        $nim = $this->request->getVar('nim');
        $tanggal_permohonan = $this->request->getVar('tanggal_permohonan');
        $jenis_kelamin = $this->request->getVar('jenis_kelamin');
        $email = $this->request->getVar('email');
        $nomor_telepon = $this->request->getVar('nomor_hp');
        $universitas = $this->request->getVar('universitas');
        $fakultas = $this->request->getVar('fakultas');
        $jenis_penelitian = $this->request->getVar('jenis_penelitian');
        $judul_penelitian = $this->request->getVar('judul_penelitian');
        $surat_permohonan = $this->request->getFile('surat_permohonan');
        $identitas = $this->request->getFile('identitas');
        $surat_pengantar = $this->request->getFile('surat_pengantar');
        $proposal = $this->request->getFile('proposal');
        $username = $this->request->getVar('username');


        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi '
                ]
            ],
            'nim' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nim harus diisi '
                ]
            ],
            'tanggal_permohonan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal permohonan harus diisi '
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin harus diisi '
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email harus diisi '
                ]
            ],
            'nomor_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor HP harus diisi '
                ]
            ],
            'universitas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Universitas harus diisi '
                ]
            ],
            'fakultas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi '
                ]
            ],
            'jenis_penelitian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Penelitian harus diisi ',

                ]
            ],
            'judul_penelitian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul Penelitian harus diisi ',

                ]
            ],
            'surat_permohonan' => [
                'rules' => 'uploaded[surat_permohonan]|ext_in[surat_permohonan,pdf]',
                'errors' => [
                    'uploaded' => 'Surat Permohonan harus diisi ',
                    'ext_in' => 'Jenis file salah'
                ]
            ],
            'identitas' => [
                'rules' => 'uploaded[surat_permohonan]|ext_in[identitas,pdf]',
                'errors' => [
                    'uploaded' => 'Identitas harus diisi ',
                    'ext_in' => 'Jenis file salah'
                ]
            ],
            'surat_pengantar' => [
                'rules' => 'uploaded[surat_permohonan]|ext_in[surat_pengantar,pdf]',
                'errors' => [
                    'uploaded' => 'Surat Pengantar harus diisi ',
                    'ext_in' => 'Jenis file salah'
                ]
            ],
            'proposal' => [
                'rules' => 'uploaded[surat_permohonan]|ext_in[proposal,pdf]',
                'errors' => [
                    'uploaded' => 'Proposal harus diisi ',
                    'ext_in' => 'Jenis file salah'
                ]
            ],

        ]);

        $valdata = [
            'nama' => $nama,
            'nim' => $nim,
            'tanggal_permohonan' => $tanggal_permohonan,
            'jenis_kelamin' => $jenis_kelamin,
            'email' => $email,
            'nomor_hp' => $nomor_telepon,
            'universitas' => $universitas,
            'fakultas' => $fakultas,
            'jenis_penelitian' => $jenis_penelitian,
            'judul_penelitian' => $judul_penelitian,
            'surat_permohonan' => $surat_permohonan,
            'identitas' => $identitas,
            'surat_pengantar' => $surat_pengantar,
            'proposal' => $proposal,

        ];

        // dd($validation->run($valttd));

        if ($validation->run($valdata) == FALSE) {
            session()->setFlashdata('validasi', $validation->getErrors());
            return redirect()->to(base_url('penelitian/v_tambah_penelitian'))->withInput();
        };


        $surat_permohonan_filename = 'Surat_Permohonan-' . time() . '.pdf';
        $surat_permohonan->move('file/surat_permohonan', $surat_permohonan_filename);
        $identitas_filename = 'Identitas-' . time() . '.pdf';
        $identitas->move('file/identitas', $identitas_filename);
        $surat_pengantar_filename = 'Surat_Pengantar-' . time() . '.pdf';
        $surat_pengantar->move('file/surat_pengantar', $surat_pengantar_filename);
        $proposal_filename = 'Proposal-' . time() . '.pdf';
        $proposal->move('file/proposal', $proposal_filename);

        $data = [
            'nama' => $nama,
            'nim' => $nim,
            'tanggal_permohonan' => $tanggal_permohonan,
            'jenis_kelamin' => $jenis_kelamin,
            'email' => $email,
            'nomor_telepon' => $nomor_telepon,
            'universitas' => $universitas,
            'fakultas' => $fakultas,
            'jenis_penelitian' => $jenis_penelitian,
            'judul_penelitian' => $judul_penelitian,
            'surat_permohonan' => $surat_permohonan_filename,
            'identitas' => $identitas_filename,
            'surat_pengantar' => $surat_pengantar_filename,
            'proposal' => $proposal_filename,
            'username' => $username
        ];



        $this->modelPenelitian->save($data);

        $db = db_connect();
        $builder = $db->table('users');
        $email_admin = $builder->select('email')->where('level', '1')->get()->getRowArray();
        $data_user = $builder->select('nama,email')->where('username', session()->get('username'))->get()->getRowArray();

        $mail = new PHPMailer(true);

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output
        $mail->isSMTP();    //Send using SMTP
        $mail->Host       = 'mail.ozavo.my.id'; //Set the SMTP server to send through
        $mail->SMTPAuth   = true; //Enable SMTP authentication
        $mail->Username   = 'okawiadnyana@ozavo.my.id'; //SMTP username
        $mail->Password   = 'vio19092019';  //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port       = 465;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );                           // Important Part PHPMailer in modern PHP

        //Recipients
        $mail->setFrom('okawiadnyana@ozavo.my.id', 'PN Bangli');
        $mail->addAddress($email_admin['email'], 'Admin');     //Add a recipient

        $mail->addCC($data_user['email'], 'User');

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Permohonan ijin penelitian';
        $mail->Body    = 'Permohonan ijin penelitian atas nama ' . $data_user['nama'] . ' telah diupload';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        session()->setFlashdata('add', 'Data berhasil disimpan');
        return redirect()->to(base_url('penelitian/v_daftar_penelitian'));
    }



    public function delete($id_url = null)
    {
        $id_swal = $this->request->getVar('id');


        if ($id_url != null) {
            $id = $id_url;
            $data_update = [
                'deleted' => 'Y'
            ];
            $this->modelPenelitian->update($id, $data_update);
            session()->setFlashdata('delete', 'Data berhasil dihapus');
            return redirect()->to(base_url('penelitian/v_daftar_penelitian'));
        } else {
            $id = $id_swal;
            $data_update = [
                'deleted' => 'Y'
            ];
            $this->modelPenelitian->update($id, $data_update);
            session()->setFlashdata('delete', 'Data berhasil dihapus');
            echo json_encode(['url' => 'penelitian/v_daftar_penelitian']);
        }
    }




    public function cekdata($id, $jenis)
    {

        $db = db_connect();

        if ($jenis == 'Pdt.G') {
            $builder = $db->table('serah_gugatan');
            $data_perkara = $builder->where('id', $id)->get()->getRowArray();

            $data = [
                'title' => 'Cek Data',
                'data_perkara' => $data_perkara
            ];

            return view('minutasi/cekdata/cekdata_gugatan', $data);
        }
        if ($jenis == 'Pdt.P') {
            $builder = $db->table('serah_permohonan');
            $data_perkara = $builder->where('id', $id)->get()->getRowArray();

            $data = [
                'title' => 'Cek Data',
                'data_perkara' => $data_perkara
            ];

            return view('minutasi/cekdata/cekdata_permohonan', $data);
        }
        if ($jenis == 'Pid.B') {
            $builder = $db->table('serah_pidana_biasa');
            $data_perkara = $builder->where('id', $id)->get()->getRowArray();

            $data = [
                'title' => 'Cek Data',
                'data_perkara' => $data_perkara
            ];

            return view('minutasi/cekdata/cekdata_pidana_biasa', $data);
        }
        if ($jenis == 'Pid.C') {
            $builder = $db->table('serah_pidana_cepat');
            $data_perkara = $builder->where('id', $id)->get()->getRowArray();

            $data = [
                'title' => 'Cek Data',
                'data_perkara' => $data_perkara
            ];

            return view('minutasi/cekdata/cekdata_pidana_cepat', $data);
        }
    }

    public function corona()
    {
        $client = \Config\Services::curlrequest();
        $dataapi = $client->request('GET', 'https://covid19.mathdro.id/api/countries/Indonesia');
        $body = json_decode($dataapi->getBody(), true);

        dd($body);


        $data = [
            'title' => 'Surat Kuasa',
            'data' => $body
        ];
        return view('suratkuasa', $data);
    }
}
