<?php



namespace App\Controllers;



use App\Models\Modeladvokat;

use App\Models\Modelagama;

use App\Models\Modelusers;

use App\Models\Modelsaksi;

use App\Models\Modelpejabat;

use PhpOffice\PhpWord\PhpWord;

use PhpOffice\PhpWord\TemplateProcessor;

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\Exception;

use Endroid\QrCode\Color\Color;

use Endroid\QrCode\Encoding\Encoding;

use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;

use Endroid\QrCode\QrCode;

use Endroid\QrCode\Label\Label;

use Endroid\QrCode\Logo\Logo;

use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;

use Endroid\QrCode\Writer\PngWriter;





class Advokatadmin extends BaseController

{



    public function __construct()

    {

        $this->modelAdvokat = new Modeladvokat();

        $this->modelAgama = new Modelagama();

        $this->modelUsers = new Modelusers();

        $this->modelSaksi = new Modelsaksi();

        $this->modelPejabat = new Modelpejabat();
    }





    public function index()

    {





        // inisiasi helper cdn

        helper('idndate_helper');



        // mendapatkan informasi covid-19

        $client = \Config\Services::curlrequest();

        $dataapi = $client->request('GET', 'https://covid19.mathdro.id/api/countries/indonesia');

        $body = json_decode($dataapi->getBody(), true);



        // mendapatkan nilai yang diterima berdasarkan session username



        $username = session()->get('username');



        $count_data = $this->modelAdvokat->getCountDataAdmin();



        $approval = json_encode($count_data);





        $data = [

            'title' => 'Home',

            'approval' => $approval,

            'positif' => $body['confirmed']['value'],

            'sembuh' => $body['recovered']['value'],

            'meninggal' => $body['deaths']['value'],

            'update' => $body['lastUpdate'],

            // if kawalcorona not error

            // 'positif' => $body[0]['positif'],

            // 'sembuh' => $body[0]['sembuh'],

            // 'meninggal' => $body[0]['meninggal'],

            // 'update' => NULL,

        ];

        return view('admin/admin_home', $data);
    }



    // View Aplly list method

    public function v_daftar_advokat_admin()

    {



        $db = db_connect();

        $builder = $db->table('permohonan_tbl');



        $data_advokat = $builder->join('proses_tbl', 'permohonan_tbl.permohonan_id=proses_tbl.permohonan_id', 'left')->join('agama', 'permohonan_tbl.agama_id=agama.agama_id', 'left')->select('permohonan_tbl.permohonan_id as adv_id, nama, tanggal_permohonan, agama, jenis_kelamin,email, nomor_telepon,nomor_sk_pengangkatan,tanggal_sk_pengangkatan,organisasi,ktp,sp_non_pns,ijazah,pkpa,upa,sk_magang,suket,sk_angkat_advokat,proses,tolak,status,ba_sumpah')->where('deleted =', null)->get()->getResultArray();



        $data = [

            'title' => 'Daftar Advokat Admin',

            'data_advokat' => $data_advokat



        ];

        return view('admin/daftar_advokat_admin', $data);
    }



    // uploade file download menthod

    public function modal_detail_file()

    {

        if ($this->request->isAJAX()) {



            $id = $this->request->getVar('id');



            $data_advokat = $this->modelAdvokat->find($id);

            $data = [

                'data_advokat' => $data_advokat

            ];



            $msg = [

                view('user/modal_detail_file', $data)

            ];

            echo json_encode($msg);
        } else {

            'Forbidden';
        }
    }



    // view modal tolak



    public function modal_tolak()

    {

        if ($this->request->isAJAX()) {



            $id = $this->request->getVar('id');





            $data = [

                'permohonan_id' => $id

            ];



            $msg = [

                view('admin/tolak_modal', $data)

            ];

            echo json_encode($msg);
        } else {

            'Forbidden';
        }
    }



    // showing modal for cetak template BA



    public function modal_cetak_template()

    {

        if ($this->request->isAJAX()) {



            $id = $this->request->getVar('id');

            $pejabat = $this->modelPejabat->findAll();

            $saksi = $this->modelSaksi->findAll();





            $data = [

                'permohonan_id' => $id,

                'pejabat' => $pejabat,

                'saksi' => $saksi

            ];



            $msg = [

                view('admin/template_modal', $data)

            ];

            echo json_encode($msg);
        } else {

            'Forbidden';
        }
    }



    // cetak template BA



    public function cetak_template()

    {

        // initialize helper for idn date

        helper(['idndate_helper']);



        // retrieve input

        $tanggal_penyumpahan = idndate($this->request->getVar('tanggal_penyumpahan'));

        $nomor_ba_sumpah = $this->request->getVar('nomor_ba_sumpah');

        $pejabat = $this->request->getVar('pejabat');

        $saksi1 = $this->request->getVar('saksi1');

        $saksi2 = $this->request->getVar('saksi2');



        $permohonan_id = $this->request->getVar('id');

        $data_permohonan = $this->modelAdvokat->find($permohonan_id);
        $tanggal_sk_pengangkatan = idndate($data_permohonan['tanggal_sk_pengangkatan']);



        // choose the right template

        if ($data_permohonan['agama_id'] == 1) {

            $templateBA = new TemplateProcessor(base_url('/template/Template_Hindu.docx'));
        } elseif ($data_permohonan['agama_id'] == 2) {

            $templateBA = new TemplateProcessor(base_url('/template/Template_Islam.docx'));
        } elseif ($data_permohonan['agama_id'] == 3) {

            $templateBA = new TemplateProcessor(base_url('/template/Template_Budha.docx'));
        } elseif ($data_permohonan['agama_id'] == 4) {

            $templateBA = new TemplateProcessor(base_url('/template/Template_Kristen_Protestan.docx'));
        } else {

            $templateBA = new TemplateProcessor(base_url('/template/Template_Kristen_Katolik.docx'));
        }



        $data_pejabat = $this->modelPejabat->find($pejabat);

        $data_saksi1 = $this->modelSaksi->find($saksi1);

        $data_saksi2 = $this->modelSaksi->find($saksi2);



        // begin to print template



        $templateBA->setValue('nomor_ba_sumpah', $nomor_ba_sumpah);

        $templateBA->setValue('hari', $tanggal_penyumpahan['hari']);

        $templateBA->setValue('tanggal', $tanggal_penyumpahan['tanggal']);

        $templateBA->setValue('pejabat', $data_pejabat['nama']);

        $templateBA->setValue('jabatan', $data_pejabat['jabatan']);

        $templateBA->setValue('nip_pejabat', $data_pejabat['nip']);

        $templateBA->setValue('saksi_1', $data_saksi1['nama']);

        $templateBA->setValue('jabatan_saksi_1', $data_saksi1['jabatan']);

        $templateBA->setValue('nip_saksi_1', $data_saksi1['nip']);

        $templateBA->setValue('saksi_2', $data_saksi2['nama']);

        $templateBA->setValue('jabatan_saksi_2', $data_saksi2['jabatan']);

        $templateBA->setValue('nip_saksi_2', $data_saksi2['nip']);

        $templateBA->setValue('nama_advokat', $data_permohonan['nama']);

        $templateBA->setValue('organisasi', $data_permohonan['organisasi']);

        $templateBA->setValue('nomor_sk_pengangkatan', $data_permohonan['nomor_sk_pengangkatan']);

        $templateBA->setValue('tanggal_sk_pengangkatan', $tanggal_sk_pengangkatan['tanggal']);



        $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $this->response->setHeader('Content-Disposition', 'attachment;filename="BA-Sumpah-' . $data_permohonan['nama'] . '.docx"');

        $pathToSave = 'php://output';

        $templateBA->saveAs($pathToSave);
    }





    public function modal_laporan()

    {

        if ($this->request->isAJAX()) {





            $msg = [

                view('admin/modal-laporan')

            ];

            echo json_encode($msg);
        } else {

            'Forbidden';
        }
    }





    // download file method

    public function download($main_dir, $dir, $file)

    {

        return $this->response->download($main_dir . '/' . $dir . '/' . $file, null);
    }



    // proses permohonan method

    public function proses($id)

    {

        // cek if data exist

        $db = db_connect();

        $builder = $db->table('proses_tbl');



        $count_data = $builder->where('permohonan_id', $id)->countAllResults();



        // get the right method, insert or update

        if ($count_data > 0) {

            $data = [



                'proses' => 'Y',

                'status' => 'Permohonan disetujui'

            ];

            $builder->where('permohonan_id', $id)->update($data);
        } else {

            $data = [

                'permohonan_id' => $id,

                'proses' => 'Y',

                'status' => 'Permohonan disetujui'

            ];

            $builder->insert($data);
        }



        // Begin email

        $data_permohonan = $this->modelAdvokat->find($id);



        $data_user = $this->modelUsers->where('username', $data_permohonan['username'])->first();

        $email_admin = $this->modelUsers->where('level_id', 1)->findAll();

        $mail = new PHPMailer(true);



        $mail = new PHPMailer(true);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output

        $mail->isSMTP();    //Send using SMTP

        // $mail->Host       = 'mail.ozavo.my.id'; //Set the SMTP server to send through

        $mail->Host       = 'smtp.gmail.com';

        $mail->SMTPAuth   = true; //Enable SMTP authentication

        // $mail->Username   = 'okawiadnyana@ozavo.my.id'; //SMTP username

        $mail->Username   = 'app.ptdenpasar@gmail.com';

        // $mail->Password   = 'vio19092019';  //SMTP password

        $mail->Password   = 'ptdenpasar12345';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption

        $mail->Port       = 465;

        $mail->SMTPOptions = array(

            'ssl' => array(

                'verify_peer' => false,

                'verify_peer_name' => false,

                'allow_self_signed' => true

            )

        );                           // Important Part PHPMailer in modern PHP





        $mail->setFrom('app.ptdenpasar@gmail.com', 'PT Denpasar');

        //Recipients admin

        foreach ($email_admin as $ea) {

            $mail->addAddress($ea['email'], 'Admin');
        }

        // Recipient user



        $mail->addCC($data_user['email'], 'User');



        $mail->isHTML(true);                                  //Set email format to HTML

        $mail->Subject = 'Permohonan pendaftaran advokat';

        $mail->Body    = 'Permohonan pendaftaran advokat atas nama ' . $data_permohonan['nama'] . '(' . $data_user['organisasi'] . ')' . ' telah disetujui';

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();



        // Set flashdata

        session()->setFlashdata('add', 'Data berhasil disimpan');



        return redirect()->to(base_url('advokatadmin/v_daftar_advokat_admin'));
    }



    // reject permohonan method

    public function tolak_advokat()

    {

        // get input

        $alasan = $this->request->getVar('alasan');

        $id = $this->request->getVar('id');



        // cek data id exist

        $db = db_connect();

        $builder = $db->table('proses_tbl');

        // get the right method, insert or update

        $count_data = $builder->where('permohonan_id', $id)->countAllResults();

        if ($count_data > 0) {

            $data = [



                'tolak' => 'Y',

                'status' => 'Ditolak : ' . $alasan

            ];

            $builder->where('id_advokat', $id)->update($data);
        } else {

            $data = [

                'permohonan_id' => $id,

                'tolak' => 'Y',

                'status' => 'Ditolak :' . $alasan

            ];

            $builder->insert($data);
        }

        // Begin email

        $data_permohonan = $this->modelAdvokat->find($id);



        $data_user = $this->modelUsers->where('username', $data_permohonan['username'])->first();

        $email_admin = $this->modelUsers->where('level_id', 1)->findAll();

        $mail = new PHPMailer(true);



        $mail = new PHPMailer(true);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output

        $mail->isSMTP();    //Send using SMTP

        // $mail->Host       = 'mail.ozavo.my.id'; //Set the SMTP server to send through

        $mail->Host       = 'smtp.gmail.com';

        $mail->SMTPAuth   = true; //Enable SMTP authentication

        // $mail->Username   = 'okawiadnyana@ozavo.my.id'; //SMTP username

        $mail->Username   = 'app.ptdenpasar@gmail.com';

        // $mail->Password   = 'vio19092019';  //SMTP password

        $mail->Password   = 'ptdenpasar12345';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption

        $mail->Port       = 465;

        $mail->SMTPOptions = array(

            'ssl' => array(

                'verify_peer' => false,

                'verify_peer_name' => false,

                'allow_self_signed' => true

            )

        );                           // Important Part PHPMailer in modern PHP





        $mail->setFrom('app.ptdenpasar@gmail.com', 'PT Denpasar');

        //Recipients admin

        foreach ($email_admin as $ea) {

            $mail->addAddress($ea['email'], 'Admin');
        }

        // Recipient user



        $mail->addCC($data_user['email'], 'User');



        $mail->isHTML(true);                                  //Set email format to HTML

        $mail->Subject = 'Permohonan pendaftaran advokat';

        $mail->Body    = 'Permohonan pendaftaran advokat atas nama ' . $data_permohonan['nama'] . '(' . $data_user['organisasi'] . ')' . ' ditolak oleh karena ' . $alasan;

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();



        // set flashdata

        session()->setFlashdata('add', 'Data berhasil disimpan');

        return redirect()->to(base_url('advokatadmin/v_daftar_advokat_admin'));
    }



    // show cetak template modal method

    public function modal_upload_ba()

    {

        if ($this->request->isAJAX()) {



            $id = $this->request->getVar('id');



            $data = [

                'permohonan_id' => $id,

            ];



            $msg = [

                view('admin/modal-upload-ba', $data)

            ];

            echo json_encode($msg);
        } else {

            'Forbidden';
        }
    }



    // upload BA method

    public function upload_ba()

    {

        // retrieve the file

        $file_ba = $this->request->getFile('ba_sumpah');

        $permohonan_id = $this->request->getVar('id');



        // begin validation

        $validation = \Config\Services::validation();



        $validation->setRules([

            'ba_sumpah' => [

                'rules' => 'uploaded[ba_sumpah]|ext_in[ba_sumpah,pdf]',

                'errors' => [

                    'uploaded' => '{field} harus diisi',

                    'ext_in' => 'Jenis file harus pdf',

                ]

            ]

        ]);



        $data_validasi = [

            'ba_sumpah' => $file_ba

        ];



        if ($validation->run($data_validasi) == FALSE) {

            session()->setFlashdata('validasi', $validation->getErrors());

            return redirect()->to(base_url('advokatadmin/v_daftar_advokat_admin'));
        }



        // begin upload and update proses

        $data_permohonan = $this->modelAdvokat->find($permohonan_id);



        $nama_file_ba = 'BA_Sumpah-' . $data_permohonan['nama'] . '-' . time() . '.' . $file_ba->guessExtension();

        $file_ba->move('file/ba_sumpah', $nama_file_ba);



        $data = [



            'ba_sumpah' => $nama_file_ba,

            'status' => 'Berita Acara telah diupload, silahkan diperiksa'

        ];



        $db = db_connect();

        $builder = $db->table('proses_tbl');



        $builder->where('permohonan_id', $permohonan_id)->update($data);



        // begin email

        $data_user = $this->modelUsers->where('username', $data_permohonan['username'])->first();

        $email_admin = $this->modelUsers->where('level_id', 1)->findAll();

        $mail = new PHPMailer(true);



        $mail = new PHPMailer(true);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;    //Enable verbose debug output

        $mail->isSMTP();    //Send using SMTP

        // $mail->Host       = 'mail.ozavo.my.id'; //Set the SMTP server to send through

        $mail->Host       = 'smtp.gmail.com';

        $mail->SMTPAuth   = true; //Enable SMTP authentication

        // $mail->Username   = 'okawiadnyana@ozavo.my.id'; //SMTP username

        $mail->Username   = 'app.ptdenpasar@gmail.com';

        // $mail->Password   = 'vio19092019';  //SMTP password

        $mail->Password   = 'ptdenpasar12345';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption

        $mail->Port       = 465;

        $mail->SMTPOptions = array(

            'ssl' => array(

                'verify_peer' => false,

                'verify_peer_name' => false,

                'allow_self_signed' => true

            )

        );                           // Important Part PHPMailer in modern PHP





        $mail->setFrom('app.ptdenpasar@gmail.com', 'PT Denpasar');

        //Recipients admin

        foreach ($email_admin as $ea) {

            $mail->addAddress($ea['email'], 'Admin');
        }

        // Recipient user



        $mail->addCC($data_user['email'], 'User');



        $mail->isHTML(true);                                  //Set email format to HTML

        $mail->Subject = 'Permohonan pendaftaran advokat';

        $mail->Body    = 'Berita Acara Sumpah atas nama ' . $data_permohonan['nama'] . '(' . $data_user['organisasi'] . ')' . ' telah diupload';

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();



        // set flashdata

        session()->setFlashdata('add', 'Data berhasil disimpan');

        return redirect()->to(base_url('advokatadmin/v_daftar_advokat_admin'));
    }





    public function notif_permohonan()

    {

        // this is sse server setting



        // if in hosting, use this setting

        $this->response->setContentType('text/event-stream');

        $this->response->setHeader('Cache-Control', 'no-cache');



        // header('Content-Type: text/event-stream');

        // header('Cache-Control: no-cache');



        $db = db_connect();

        $builder = $db->table('permohonan_tbl');

        $data = $builder->join('proses_tbl', 'permohonan_tbl.permohonan_id=proses_tbl.permohonan_id', 'left')->where('proses', null)->where('tolak', null)->where('deleted', null)->countAllResults();



        if ($data > 0) {

            echo "data: {$data}\n\n";

            // ob_end_flush();

            flush();
        } else {

            echo "data: {$data}\n\n";

            // ob_end_flush();

            flush();
        }
    }



    public function v_user_register()

    {

        $db = db_connect();

        $builder = $db->table('level');

        $level = $builder->get()->getResultArray();



        $data = [

            'title' => 'Register User',

            'level' => $level,

            'validation' => \Config\Services::validation()

        ];



        return view('admin/tambah_user', $data);
    }

    public function tambah_user($admin = null)

    {

        $nama = $this->request->getVar('nama');

        $organisasi = $this->request->getVar('organisasi');

        $email = $this->request->getVar('email');

        $nomor_hp = $this->request->getVar('nomor_hp');

        $username = $this->request->getVar('username');

        $password = $this->request->getVar('password');

        $password2 = $this->request->getVar('password2');

        $level = $this->request->getVar('level');



        $data = [

            'nama' => $nama,

            'organisasi' => $organisasi,

            'email' => $email,

            'nomor_hp' => $nomor_hp,

            'username' => $username,

            'password' => $password,

            'password2' => $password2,

            'level' => $level

        ];



        $validation = \Config\Services::validation();

        $validation->setRules([

            'nama' => [

                'rules' => 'required',

                'errors' => [

                    'required' => '{field} harus diisi'

                ]

            ],

            'organisasi' => [

                'rules' => 'required',

                'errors' => [

                    'required' => '{field} harus diisi'

                ]

            ],



            'email' => [

                'rules' => 'required',

                'errors' => [

                    'required' => '{field} harus diisi'

                ]

            ],

            'nomor_hp' => [

                'rules' => 'required',

                'errors' => [

                    'required' => '{field} harus diisi'

                ]

            ],



            'username' => [

                'rules' => 'required|is_unique[users.username]',

                'errors' => [

                    'required' => '{field} harus diisi',

                    'is_unique' => 'Username sudah ada'

                ]

            ],

            'password' => [

                'rules' => 'required',

                'errors' => [

                    'required' => '{field} harus diisi',



                ]

            ], 'password2' => [

                'rules' => 'required|matches[password]',

                'errors' => [

                    'required' => '{field} harus diisi',

                    'matches' => 'Konfirmasi password tidak sama'



                ]

            ], 'level' => [

                'rules' => 'required',

                'errors' => [

                    'required' => '{field} harus diisi',





                ]

            ],



        ]);



        if ($validation->run($data) == FALSE) {

            return redirect()->to(base_url('advokatadmin/v_user_register'))->withInput();
        }



        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $datainsert = [

            'nama' => $nama,

            'organisasi' => $organisasi,

            'email' => $email,

            'nomor_hp' => $nomor_hp,

            'username' => $username,

            'password' => $password_hash,

            'level_id' => $level

        ];



        $db = \Config\Database::connect('');

        $builder = $db->table('users');



        $builder->insert($datainsert);

        session()->setFlashdata('pesan', 'Akun berhasil ditambahkan');

        return redirect()->to(base_url('advokatadmin/v_user'));
    }



    public function v_user()

    {



        $db = db_connect();

        $builder = $db->table('users');

        $data_user = $builder->join('level', 'users.level_id=level.level_id', 'left')

            ->select('user_id,nama,organisasi,email,nomor_hp,username,nama_level')

            ->get()->getResultArray();



        $data = [

            'title' => 'Daftar User',

            'data_user' => $data_user

        ];



        return view('admin/daftar_user', $data);
    }



    public function hapus_user($user_id)

    {



        $this->modelUsers->delete($user_id);

        session()->setFlashdata('delete', 'User berhasil dihapus');



        return redirect()->to(base_url('advokatadmin/v_user'));
    }





    public function cetak_laporan()

    {

        helper('idndate_helper');

        $tgl_awal = $this->request->getVar('tgl_awal');

        $tgl_akhir = $this->request->getVar('tgl_akhir');

        $tanggal_laporan = idndate($this->request->getVar('tanggal_laporan'))['tanggal'];



        $tgl_awal_cetak = idndate($tgl_awal)['tanggal'];

        $tgl_akhir_cetak = idndate($tgl_akhir)['tanggal'];





        $db = db_connect();

        $builder = $db->table('permohonan_tbl');

        $data_laporan = $builder->join('agama', 'permohonan_tbl.agama_id=agama.agama_id')->where(['tanggal_permohonan>=' => $tgl_awal, 'tanggal_permohonan<=' => $tgl_akhir])->where('deleted', null)->get()->getResultArray();



        $panitera = $this->modelPejabat->where('jabatan', 'Panitera')->first();



        $data = [

            'data_laporan' => $data_laporan,

            'tanggal_awal' => $tgl_awal_cetak,

            'tanggal_akhir' => $tgl_akhir_cetak,

            'tanggal_laporan' => $tanggal_laporan,

            'panitera' => $panitera,

        ];



        $cetak =  view('admin/laporan_advokat', $data);



        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);





        $mpdf->WriteHTML($cetak);

        $this->response->setContentType('application/pdf');



        $mpdf->Output("data.pdf", "I");
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
}
