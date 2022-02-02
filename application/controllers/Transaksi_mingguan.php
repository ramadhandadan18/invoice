<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_mingguan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_mingguan_m');

        if (!$this->session->userdata('is_login') == true) {
            redirect('login');
        }
    }

    public function index()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Transaksi_mingguan');
        $this->load->view('templates/footer');
    }

    public function index_bulanan()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Transaksi_bulanan');
        $this->load->view('templates/footer');
    }

    public function index_tahunan()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Transaksi_tahunan');
        $this->load->view('templates/footer');
    }

    function echopre($dt)
    {
        echo "<pre>";
        print_r($dt);
        echo "</pre>";
    }

    public function get_data($fill_1, $fill_2, $fill_3, $fill_4, $fill_5, $export = 0)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;
        $_POST['bulan'] = $fill_3;
        $_POST['minggu'] = $fill_4;
        $_POST['kategori'] = $fill_5;
        $transaksi = $this->Transaksi_mingguan_m->get_data($_POST);

        $i = 0;
        $jumlah = 0;
        $dt_jum = [];
        if (!empty($transaksi)) {
            foreach ($transaksi as $k => $v) {
                $dt_final[$i]['id'] = $v['id'];
                $dt_final[$i]['no'] = (string)($k + 1);
                $dt_final[$i]['pegawai_no'] = $v['pegawai_no'];
                $dt_final[$i]['pegawai_nama'] = strtoupper($v['pegawai_nama']);
                $dt_final[$i]['tgl_transaksi'] = $v['tgl_transaksi'];
                $dt_final[$i]['mingguan'] = $v['mingguan'];
                $dt_final[$i]['kategori'] = $v['kategori'];
                $dt_final[$i]['qty'] = number_format($v['qty']);
                $dt_final[$i]['harga'] = number_format($v['harga']);
                $dt_final[$i]['deskripsi'] = ($v['deskripsi']);
                $dt_final[$i]['total'] = number_format($v['total']);
                $jumlah += $v['total'];
                $i++;
            }
            $dt_jum[$i]['pegawai_nama'] = 'Jumlah';
            $dt_jum[$i]['total'] = number_format($jumlah);
            $i++;
        } else {
            $dt_final[$i]['pegawai_id'] = '';
            $dt_final[$i]['pegawai_no'] = '';
            $dt_final[$i]['pegawai_nama'] = 'Data is null';
            $dt_final[$i]['tgl_transaksi'] = '';
            $dt_final[$i]['mingguan'] = '';
            $dt_final[$i]['kategori'] = '';
            $dt_final[$i]['harga'] = '';
            $dt_final[$i]['deskripsi'] = '';
            $dt_final[$i]['qty'] = '';
            $dt_final[$i]['total'] = '';
        }

        if ($export == 1) {
            $data = array_merge($dt_final, $dt_jum);
            return $data;
        }

        $object = json_decode(json_encode($dt_final), FALSE);
        echo json_encode(array('response' => $object));
    }

    public function get_data_bulanan($fill_1, $fill_2, $fill_3, $fill_4, $fill_5, $export = 0)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;
        $_POST['bulan'] = $fill_3;

        $data_pegawai = $this->Transaksi_mingguan_m->get_data_pegawai();
        $transaksi = $this->Transaksi_mingguan_m->data_bulanan($_POST);
        $data_garasi = $this->Transaksi_mingguan_m->data_bulanan_garasi($_POST);
        $garasi = [];
        foreach ($data_garasi as $key => $value) {
            $garasi[$value['pegawai_no']] = $value;
        }
        $data_gaji = $this->Transaksi_mingguan_m->data_gaji($_POST);
        $gaji = [];
        foreach ($data_gaji as $key => $value) {
            $gaji[$value['pegawai_no']] = $value;
        }
        $i = 0;
        $jumlah = 0;
        for ($aa = 1; $aa <= 5; $aa++) {
            $jum_mingguan['v' . $aa] = 0;
            $jum_mingguan['gaji'] = 0;
            $jum_mingguan['garasi'] = 0;
            $jum_mingguan['pengeluaran'] = 0;
        }
        $dt_jum = [];
        if (!empty($data_pegawai) && !empty($transaksi)) {
            foreach ($data_pegawai as $key => $value) {
                $total = 0;
                foreach ($transaksi as $k => $v) {
                    if ($value['pegawai_nama'] == $v['pegawai_nama']) {
                        $dt_final[$i]['pegawai_nama'] = $v['pegawai_nama'];
                        $dt_final[$i]['gaji'] = array_key_exists($v['pegawai_no'], $gaji) ? $gaji[$v['pegawai_no']]['total'] : 0;
                        $dt_final[$i]['garasi'] = array_key_exists($v['pegawai_no'], $garasi) ? $garasi[$v['pegawai_no']]['total'] : 0;
                        $aa = $v['mingguan'];
                        $dt_final[$i]['v' . $aa] = $v['total'];
                        $total += $v['total'];
                        $dt_final[$i]['pengeluaran'] = $total + $dt_final[$i]['garasi'];
                        $dt_final[$i]['total'] = $dt_final[$i]['gaji'] - $dt_final[$i]['pengeluaran'];
                        $jum_mingguan['v' . $aa] += $dt_final[$i]['v' . $aa];
                    }
                }
                $jum_mingguan['gaji'] += array_key_exists($i, $dt_final) ? $dt_final[$i]['gaji'] : 0;
                $jum_mingguan['garasi'] += array_key_exists($i, $dt_final) ? $dt_final[$i]['garasi'] : 0;
                $jum_mingguan['pengeluaran'] += array_key_exists($i, $dt_final) ? $dt_final[$i]['pengeluaran'] : 0;
                $i++;
            }
            $dt_jum[$i]['pegawai_nama'] = 'Jumlah';
            for ($aa = 1; $aa <= 5; $aa++) {
                $dt_jum[$i]['v' . $aa] = number_format($jum_mingguan['v' . $aa]);
                $jumlah += $jum_mingguan['v' . $aa];
            }
            $jumlah = $jumlah + $jum_mingguan['garasi'];
            $dt_jum[$i]['gaji'] = number_format($jum_mingguan['gaji']);
            $dt_jum[$i]['pengeluaran'] = number_format($jum_mingguan['pengeluaran']);
            $dt_jum[$i]['garasi'] = number_format($jum_mingguan['garasi']);
            $dt_jum[$i]['total'] = number_format($jum_mingguan['gaji'] - $jumlah);
            $i++;
        } else {
            $dt_final[$i]['pegawai_nama'] = 'Data is null';
            for ($aa = 1; $aa <= 5; $aa++) {
                $dt_final[$i]['v' . $aa] = '';
            }
            $dt_final[$i]['gaji'] = '';
            $dt_final[$i]['pengeluaran'] = '';
            $dt_final[$i]['garasi'] = '';
            $dt_final[$i]['total'] = '';
        }
        $dt = array();
        $i = 0;
        foreach ($dt_final as $key => $value) {
            $dt[$i] = $value;
            $dt[$i]['NO'] = (string)($key + 1);
            for ($aa = 1; $aa <= 5; $aa++) {
                $dt[$i]['v' . $aa] = isset($value['v' . $aa]) && $value['v' . $aa] != '' ? number_format($value['v' . $aa]) : '';
            }
            $dt[$i]['gaji'] = isset($value['gaji']) && $value['gaji'] != '' ? number_format($value['gaji']) : '';
            $dt[$i]['garasi'] = isset($value['garasi']) && $value['garasi'] != '' ? number_format($value['garasi']) : '';
            $dt[$i]['pengeluaran'] = isset($value['pengeluaran']) && $value['pengeluaran'] != '' ? number_format($value['pengeluaran']) : '';
            $dt[$i]['total'] = isset($value['total']) && $value['total'] != '' ? number_format($value['total']) : '';
            $i++;
        }

        if ($export != 0) {
            $data = array_merge($dt, $dt_jum);
            return $data;
        }

        $object = json_decode(json_encode($dt), FALSE);
        echo json_encode(array('response' => $object));
    }

    public function get_data_tahunan($fill_1, $fill_2, $export = 0)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;

        $data_pegawai = $this->Transaksi_mingguan_m->get_data_pegawai();
        $transaksi = $this->Transaksi_mingguan_m->data_tahunan($_POST);
        $data_gaji = $this->Transaksi_mingguan_m->data_gaji($_POST);
        $gaji = [];
        foreach ($data_gaji as $key => $value) {
            $aa = $value['bulan'] >= 10 ? $value['bulan'] : substr($value['bulan'], 1);
            $gaji[$value['pegawai_no']][$aa] = $value;
        }
        $i = 0;
        $jumlah = 0;
        for ($aa = 1; $aa <= 12; $aa++) {
            $jum_bulan['v' . $aa] = 0;
        }
        $dt_jum = [];
        if (!empty($data_pegawai) && !empty($transaksi)) {
            foreach ($data_pegawai as $key => $value) {
                $total = 0;
                foreach ($transaksi as $k => $v) {
                    if ($value['pegawai_nama'] == $v['pegawai_nama']) {
                        $dt_final[$i]['pegawai_nama'] = $v['pegawai_nama'];
                        $aa = $v['bulan'] >= 10 ? $v['bulan'] : substr($v['bulan'], 1);
                        $dt_final[$i]['gaji' . $aa] = array_key_exists($v['pegawai_no'], $gaji) ? (array_key_exists($aa, $gaji[$v['pegawai_no']]) ? $gaji[$v['pegawai_no']][$aa]['total'] : 0) : 0;
                        $dt_final[$i]['v' . $aa] = $dt_final[$i]['gaji' . $aa] - $v['value'];
                        $total += $dt_final[$i]['v' . $aa];
                        $dt_final[$i]['total'] = $total;
                        $jum_bulan['v' . $aa] += $dt_final[$i]['v' . $aa];
                    }
                }
                $i++;
            }
            $dt_jum[$i]['pegawai_nama'] = 'Jumlah';
            for ($aa = 1; $aa <= 12; $aa++) {
                $dt_jum[$i]['v' . $aa] = number_format($jum_bulan['v' . $aa]);
                $jumlah += $jum_bulan['v' . $aa];
            }
            $dt_jum[$i]['total'] = number_format($jumlah);
            $i++;
        } else {
            $dt_final[$i]['pegawai_nama'] = 'Data is null';
            for ($aa = 1; $aa <= 12; $aa++) {
                $dt_final[$i]['v' . $aa] = '';
            }
            $dt_final[$i]['gaji'] = '';
            $dt_final[$i]['total'] = '';
        }
        $dt = array();
        $i = 0;
        foreach ($dt_final as $key => $value) {
            $dt[$i] = $value;
            $dt[$i]['NO'] = (string)($key + 1);
            for ($aa = 1; $aa <= 12; $aa++) {
                $dt[$i]['v' . $aa] = isset($value['v' . $aa]) && $value['v' . $aa] != '' ? number_format($value['v' . $aa]) : '';
            }
            $dt[$i]['gaji'] = isset($value['gaji']) && $value['gaji'] != '' ? number_format($value['gaji']) : '';
            $dt[$i]['total'] = isset($value['total']) && $value['total'] != '' ? number_format($value['total']) : '';
            $i++;
        }

        if ($export != 0) {
            $data = array_merge($dt, $dt_jum);
            return $data;
        }

        $object = json_decode(json_encode($dt), FALSE);
        echo json_encode(array('response' => $object));
    }

    public function get_data_pegawai()
    {
        $pegawai = $this->Transaksi_mingguan_m->get_data_pegawai();
        $dt_pegawai[0]['pegawai_id'] = 'ALL';
        $dt_pegawai[0]['pegawai_nama'] = 'ALL';
        $i = 1;
        foreach ($pegawai as $key => $value) {
            $dt_pegawai[$i]['pegawai_id'] = $value['pegawai_no'];
            $dt_pegawai[$i]['pegawai_nama'] = $value['pegawai_nama'];
            $i++;
        }

        $object = json_decode(json_encode($dt_pegawai), FALSE);
        echo json_encode($object);
    }

    public function get_data_kategori()
    {
        $kategori = $this->Transaksi_mingguan_m->get_data_kategori();
        $dt_kategori[0]['kategori_id'] = 'ALL';
        $dt_kategori[0]['kategori_nama'] = 'ALL';
        $i = 1;
        foreach ($kategori as $key => $value) {
            $dt_kategori[$i]['kategori_id'] = $value['kategori_no'];
            $dt_kategori[$i]['kategori_nama'] = $value['kategori_nama'];
            $i++;
        }

        $object = json_decode(json_encode($dt_kategori), FALSE);
        echo json_encode($object);
    }

    public function get_data_tahun()
    {
        $data[0]['tahun'] = date('Y');
        $data[0]['tahun_desc'] = date('Y');

        $years_dropdown = array();
        $y = date('Y') - 2;
        $y1 = $y + 4;
        $a = 1;
        for ($i = $y; $i <= $y1; $i++) {
            $data[$a]['tahun'] = $i;
            $data[$a]['tahun_desc'] = $i;
            $a++;
        }
        $object = json_decode(json_encode($data), FALSE);
        echo json_encode($object);
    }

    public function get_data_bulan($export = 0)
    {
        $data[0]['bulan'] = 'ALL';
        $data[0]['bulan_desc'] = 'ALL';

        $data[1]['bulan'] = '01';
        $data[1]['bulan_desc'] = 'JANUARI';
        $data[2]['bulan'] = '02';
        $data[2]['bulan_desc'] = 'FEBRUARI';
        $data[3]['bulan'] = '03';
        $data[3]['bulan_desc'] = 'MARET';
        $data[4]['bulan'] = '04';
        $data[4]['bulan_desc'] = 'APRIL';
        $data[5]['bulan'] = '05';
        $data[5]['bulan_desc'] = 'MEI';
        $data[6]['bulan'] = '06';
        $data[6]['bulan_desc'] = 'JUNI';
        $data[7]['bulan'] = '07';
        $data[7]['bulan_desc'] = 'JULI';
        $data[8]['bulan'] = '08';
        $data[8]['bulan_desc'] = 'AGUSTUS';
        $data[9]['bulan'] = '09';
        $data[9]['bulan_desc'] = 'SEPTEMBER';
        $data[10]['bulan'] = '10';
        $data[10]['bulan_desc'] = 'OKTOBER';
        $data[11]['bulan'] = '11';
        $data[11]['bulan_desc'] = 'NOVEMBER';
        $data[12]['bulan'] = '12';
        $data[12]['bulan_desc'] = 'DESEMBER';

        if ($export != 0)
            return $data;
        $object = json_decode(json_encode($data), FALSE);
        echo json_encode($object);
    }

    public function get_data_bulan_2($export = 0)
    {
        $data[0]['bulan'] = date('m');
        $data[0]['bulan_desc'] = strtoupper(date('F'));

        $data[1]['bulan'] = '01';
        $data[1]['bulan_desc'] = 'JANUARI';
        $data[2]['bulan'] = '02';
        $data[2]['bulan_desc'] = 'FEBRUARI';
        $data[3]['bulan'] = '03';
        $data[3]['bulan_desc'] = 'MARET';
        $data[4]['bulan'] = '04';
        $data[4]['bulan_desc'] = 'APRIL';
        $data[5]['bulan'] = '05';
        $data[5]['bulan_desc'] = 'MEI';
        $data[6]['bulan'] = '06';
        $data[6]['bulan_desc'] = 'JUNI';
        $data[7]['bulan'] = '07';
        $data[7]['bulan_desc'] = 'JULI';
        $data[8]['bulan'] = '08';
        $data[8]['bulan_desc'] = 'AGUSTUS';
        $data[9]['bulan'] = '09';
        $data[9]['bulan_desc'] = 'SEPTEMBER';
        $data[10]['bulan'] = '10';
        $data[10]['bulan_desc'] = 'OKTOBER';
        $data[11]['bulan'] = '11';
        $data[11]['bulan_desc'] = 'NOVEMBER';
        $data[12]['bulan'] = '12';
        $data[12]['bulan_desc'] = 'DESEMBER';

        if ($export != 0)
            return $data;
        $object = json_decode(json_encode($data), FALSE);
        echo json_encode($object);
    }

    public function get_data_minggu()
    {
        $data[0]['minggu'] = 'ALL';
        $data[0]['minggu_desc'] = 'ALL';
        $a = 1;
        for ($i = 1; $i <= 5; $i++) {
            $data[$a]['minggu'] = $i;
            $data[$a]['minggu_desc'] = 'Minggu ke- ' . $i;
            $a++;
        }

        $object = json_decode(json_encode($data), FALSE);
        echo json_encode($object);
    }

    // public function get_data_pegawai() {
    //     $pegawai = $this->Transaksi_mingguan_m->get_data_pegawai();        
    //     echo json_encode($pegawai);
    // }

    public function save_add()
    {
        $data = array(
            'pegawai_id' => $this->input->post('pegawai_id'),
            'tanggal' => $this->input->post('tanggal'),
            'mingguan' => $this->input->post('mingguan'),
            'v1' => $this->input->post('v1'),
        );

        $result = $this->Transaksi_mingguan_m->save_add($data);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function get_data_by_id($id)
    {

        $transaksi = $this->Transaksi_mingguan_m->get_data_by_id($id);
        foreach ($transaksi as $key => $value) {
            $data['id'] = $value['id'];
            $data['pegawai_id'] = $value['pegawai_id'];
            $data['tanggal'] = $value['tanggal'];
            $data['mingguan'] = $value['mingguan'];
            $data['v1'] = $value['v1'];
        }
        $data_obj = (object)$data;
        // $this->echopre($data_obj);die;
        echo json_encode($data_obj);
    }

    public function save_edit()
    {
        $id = $this->input->post('id');
        $data = array(
            'pegawai_id' => $this->input->post('pegawai_id'),
            'tanggal' => $this->input->post('tanggal'),
            'mingguan' => $this->input->post('mingguan'),
            'v1' => $this->input->post('v1'),
        );
        $result = $this->Transaksi_mingguan_m->save_edit($data, $id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function save_delete()
    {
        $id = $this->input->post('id');
        $result = $this->Transaksi_mingguan_m->deleted_data($id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function export_data($fill_1, $fill_2, $fill_3, $fill_4, $fill_5)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;
        $_POST['bulan'] = $fill_3;
        $_POST['minggu'] = $fill_4;
        $_POST['kategori'] = $fill_5;
        $transaksi = $this->get_data($fill_1, $fill_2, $fill_3, $fill_4, $fill_5, 1);

        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();


        $fontHeader = array(
            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C5D9F1')
            )
        );
        $fontHeaderjumlah = array(
            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '997950')
            )
        );
        $allborder  = array(

            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
        );
        $boldfont = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            )
        );
        //-----------DATA FOR EXCEL---------------//
        $data['SINGLE'][] = array('A', '5', 'NO', 'no');
        $data['SINGLE'][] = array('B', '20', 'NO KENDARAAN', 'pegawai_no');
        $data['SINGLE'][] = array('C', '50', 'NAMA', 'pegawai_nama');
        $data['SINGLE'][] = array('D', '20', 'TANGGAL TRANSAKSI', 'tgl_transaksi');
        $data['SINGLE'][] = array('E', '20', 'MINGGU KE', 'mingguan');
        $data['SINGLE'][] = array('F', '20', 'KATEGORI', 'kategori');
        $data['SINGLE'][] = array('G', '20', 'QTY', 'qty');
        $data['SINGLE'][] = array('H', '20', 'HARGA', 'harga');
        $data['SINGLE'][] = array('I', '20', 'DESKRIPSI', 'deskripsi');
        $data['SINGLE'][] = array('J', '20', 'TOTAL', 'total');




        //-----------END OF DATA FOR EXCEL---------------//
        $h1 =   array(
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A2:P6')->applyFromArray($h1);
        // $objPHPExcel->getActiveSheet()->protectCells('A2:Q4', 'HEADER');
        $objPHPExcel->getActiveSheet()
            ->mergeCells('C2:F2')
            ->setCellValue('C2', 'PT. BAHARI SEJAHTERA ABADI')
            ->mergeCells('C3:F3')
            ->setCellValue('C3', 'LAPORAN MINGGUAN');

        $objPHPExcel->setActiveSheetIndex(0);
        $start = 9;
        foreach ($data['SINGLE'] as $k => $v) {

            $objPHPExcel->getActiveSheet()
                ->mergeCells($v[0] . '8:' . $v[0] . '9')
                ->setCellValue($v[0] . '8', $v[2])
                ->getColumnDimension($v[0])
                ->setWidth($v[1]);

            $n = 10;
            foreach ($transaksi as $kk => $vv) {
                if (!empty($vv[$v[3]])) {
                    if ($v[2] == 'NAMA PEGAWAI') {
                        $objPHPExcel->getActiveSheet()
                            ->setCellValueExplicit($v[0] . $n, strtoupper($vv[$v[3]]), PHPExcel_Cell_DataType::TYPE_STRING);
                    } else {
                        $objPHPExcel->getActiveSheet()
                            ->setCellValue($v[0] . $n, $vv[$v[3]]);
                    }
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($v[0] . $n, '');
                }
                if ($v[2] == 'NAMA PEGAWAI') {
                    $start++;
                }
                $n++;
            }
        }


        //TITLE
        $objPHPExcel->getActiveSheet()->setTitle('EXPORT MINGGUAN');


        //STYLING
        $objPHPExcel->getActiveSheet()->getStyle('A8:I9')->applyFromArray($fontHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A8:I' . $start)->applyFromArray($allborder);

        // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
        // $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ebudget2020');
        // $objPHPExcel->getActiveSheet()->freezePane('C10');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="EXPORT TRANSAKSI MINGGUAN.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function export_data_bulanan($fill_1, $fill_2, $fill_3, $fill_4, $fill_5)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;
        $_POST['bulan'] = $fill_3;
        $_POST['minggu'] = $fill_4;
        $_POST['kategori'] = $fill_5;
        $dt_final = $this->get_data_bulanan($fill_1, $fill_2, $fill_3, $fill_4, $fill_5, 1);
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();


        $fontHeader = array(
            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C5D9F1')
            )
        );
        $fontHeaderjumlah = array(
            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '997950')
            )
        );
        $allborder  = array(

            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
        );
        $boldfont = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            )
        );
        //-----------DATA FOR EXCEL---------------//
        $data['SINGLE'][] = array('A', '5', 'NO', 'no');
        $data['SINGLE'][] = array('B', '50', 'NAMA PEGAWAI', 'pegawai_nama');
        $data['SINGLE'][] = array('C', '20', 'MINGGUAN 1', 'v1');
        $data['SINGLE'][] = array('D', '20', 'MINGGUAN 2', 'v2');
        $data['SINGLE'][] = array('E', '20', 'MINGGUAN 3', 'v3');
        $data['SINGLE'][] = array('F', '20', 'MINGGUAN 4', 'v4');
        $data['SINGLE'][] = array('G', '20', 'MINGGUAN 5', 'v5');
        $data['SINGLE'][] = array('H', '20', 'GARASI', 'garasi');
        $data['SINGLE'][] = array('I', '20', 'PENGELUARAN', 'pengeluaran');
        $data['SINGLE'][] = array('J', '20', 'PEMASUKAN', 'gaji');
        $data['SINGLE'][] = array('K', '20', 'TOTAL', 'total');


        //-----------END OF DATA FOR EXCEL---------------//
        $h1 =   array(
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            )
        );

        $monthNum  = $_POST['bulan'];
        $monthName = strtoupper(date('F', mktime(0, 0, 0, $monthNum, 10)));

        $objPHPExcel->getActiveSheet()
            ->mergeCells('C2:I2')
            ->setCellValue('C2', 'PT. BAHARI SEJAHTERA ABADI')
            ->mergeCells('C3:I3')
            ->setCellValue('C3', 'LAPORAN BULANAN')
            ->mergeCells('C4:I4')
            ->setCellValue('C4', 'BULAN : ' . $monthName);
        $objPHPExcel->getActiveSheet()->getStyle('A2:I6')->applyFromArray($h1);

        $objPHPExcel->setActiveSheetIndex(0);
        $start = 9;
        foreach ($data['SINGLE'] as $k => $v) {

            $objPHPExcel->getActiveSheet()
                ->mergeCells($v[0] . '8:' . $v[0] . '9')
                ->setCellValue($v[0] . '8', $v[2])
                ->getColumnDimension($v[0])
                ->setWidth($v[1]);

            $n = 10;
            foreach ($dt_final as $kk => $vv) {
                if (!empty($vv[$v[3]])) {
                    if ($v[2] == 'NAMA PEGAWAI') {
                        $objPHPExcel->getActiveSheet()
                            ->setCellValueExplicit($v[0] . $n, strtoupper($vv[$v[3]]), PHPExcel_Cell_DataType::TYPE_STRING);
                    } else {
                        $objPHPExcel->getActiveSheet()
                            ->setCellValue($v[0] . $n, $vv[$v[3]]);
                    }
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($v[0] . $n, '');
                }
                if ($v[2] == 'NAMA PEGAWAI') {
                    $start++;
                }
                $n++;
            }
        }


        //TITLE
        $objPHPExcel->getActiveSheet()->setTitle('EXPORT BULANAN');


        //STYLING
        $objPHPExcel->getActiveSheet()->getStyle('A8:K9')->applyFromArray($fontHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A8:K' . $start)->applyFromArray($allborder);
        // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
        // $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ebudget2020');
        // $objPHPExcel->getActiveSheet()->freezePane('C10');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="EXPORT TRANSAKSI BULAN ' . $monthName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function export_data_tahunan($fill_1, $fill_2)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;
        $transaksi = $this->get_data_tahunan($_POST['pegawai'], $_POST['tahun'], 1);
        // $this->echopre($transaksi);die;        

        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();


        $fontHeader = array(
            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'C5D9F1')
            )
        );
        $fontHeaderjumlah = array(
            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '997950')
            )
        );
        $allborder  = array(

            'borders' => array(
                'allborders' =>
                array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
        );
        $boldfont = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            )
        );
        //-----------DATA FOR EXCEL---------------//
        $data['SINGLE'][] = array('A', '5', 'NO', 'NO');
        $data['SINGLE'][] = array('B', '50', 'NAMA PEGAWAI', 'pegawai_nama');
        $bulan = $this->get_data_bulan(1);
        foreach (range('C', 'N') as $key => $value) {
            $data['SINGLE'][] = array($value, '20', $bulan[$key + 1]['bulan_desc'], 'v' . ($key + 1));
        }
        $data['SINGLE'][] = array('O', '20', 'TOTAL', 'total');


        //-----------END OF DATA FOR EXCEL---------------//
        $h1 =   array(
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A2:P6')->applyFromArray($h1);
        // $objPHPExcel->getActiveSheet()->protectCells('A2:Q4', 'HEADER');
        $objPHPExcel->getActiveSheet()
            ->mergeCells('C2:F2')
            ->setCellValue('C2', 'PT. BAHARI SEJAHTERA ABADI')
            ->mergeCells('C3:F3')
            ->setCellValue('C3', 'LAPORAN TAHUNAN')
            ->mergeCells('C4:F4')
            ->setCellValue('C4', 'TAHUN : ' . $_POST['tahun']);

        $objPHPExcel->setActiveSheetIndex(0);
        $start = 9;
        foreach ($data['SINGLE'] as $k => $v) {

            $objPHPExcel->getActiveSheet()
                ->mergeCells($v[0] . '8:' . $v[0] . '9')
                ->setCellValue($v[0] . '8', $v[2])
                ->getColumnDimension($v[0])
                ->setWidth($v[1]);

            $n = 10;
            foreach ($transaksi as $kk => $vv) {
                if (!empty($vv[$v[3]])) {
                    if ($v[2] == 'NAMA PEGAWAI') {
                        $objPHPExcel->getActiveSheet()
                            ->setCellValueExplicit($v[0] . $n, strtoupper($vv[$v[3]]), PHPExcel_Cell_DataType::TYPE_STRING);
                    } else {
                        $objPHPExcel->getActiveSheet()
                            ->setCellValue($v[0] . $n, $vv[$v[3]]);
                    }
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($v[0] . $n, '');
                }
                if ($v[2] == 'NAMA PEGAWAI') {
                    $start++;
                }
                $n++;
            }
        }


        //TITLE
        $objPHPExcel->getActiveSheet()->setTitle('EXPORT TAHUNAN');


        //STYLING
        $objPHPExcel->getActiveSheet()->getStyle('A8:O9')->applyFromArray($fontHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A8:O' . $start)->applyFromArray($allborder);
        // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
        // $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ebudget2020');
        // $objPHPExcel->getActiveSheet()->freezePane('C10');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="EXPORT TRANSAKSI TAHUN ' . $_POST['tahun'] . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}
