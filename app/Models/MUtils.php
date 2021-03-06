<?php

namespace App\Models;

class MUtils extends BaseModel
{
    public function cekEmail($email)
    {
        $i = $this->db->table('user')->where('email', $email)->countAllResults();
        if ($i > 0) $this->ErrorRespon('Email Sudah Digunakan..');
        $this->SuccessRespon('Email Masih Tersedia..');
    }
    public function getCountry()
    {
        $DB = $this->db->table('country');
        $data = $DB->get()->getResultArray();
        return $data;
    }
    public function otpVerify($data)
    {
        $email = str_decrypt($data['key']);
        $DB = $this->db->table('user')
            ->where('email', $email)
            ->where('kode_otp', $data['kode_otp']);
        $i = $DB->countAllResults();
        if (!$i) $this->ErrorRespon('Kode OTP Tidak Cocok..');
        $DB->set('is_active', '1')->update();
        return $email;
    }
    public function historyUser($log)
    {
        $log['user_id'] = $this->session->get('user_id');
        $log['user_level_id'] = $this->session->get('user_level_id');
        if (!isset($log['history_keterangan'])) $log['history_keterangan'] = "Melakukan " . $log['history_action'] . " Pada Waktu " . date('Y-m-d H:i:s');
        $log['created_time'] = date('Y-m-d H:i:s');
        $this->db->table('history_user')->set($log)->insert();
    }
    public function countData($set = [])
    {
        $i = $this->db->table($set['table'])
            ->where($set['where'])
            ->countAllResults();
        return $i;
    }
    public function countChild($set = [])
    {
        $i = $this->db->table($set['table'])
            ->where($set['parent'] . '_id', $set['id'])
            ->countAllResults();
        return $i;
    }
    public function getShowItem($arr = [])
    {
        $m = $this->db->table($arr['table'])
            ->select($arr['select'])
            ->where($arr['where'])
            ->get()
            ->getRowArray();
        return $m;
    }
    public function getCards()
    {
        $i['users'] = $this->db->table('user')
            ->where('user_level_id', 2)
            ->countAllResults();
        $i['movies'] = $this->db->table('video')
            ->countAllResults();
        $i['visitor'] = $this->db->table('statistik')
            ->selectSum('statistik_count')
            ->get()
            ->getRow();
        return $i;
    }
    public function getSelect2($arr = [])
    {
        $keyword = $this->input->getGet('search');
        $DB = $this->db->table($arr['table']);

        if (isset($arr['customize'])) $DB->select($arr['customize']['value'] . ' as id, ' . $arr['customize']['text'] . ' as text');
        if (!isset($arr['customize'])) $DB->select($arr['table'] . '_id as id,' . $arr['table'] . '_nama as text');

        if ($keyword) $DB->like($arr['table'] . '_nama', $keyword);
        if (isset($arr['where'])) $DB->where($arr['where']);
        if (isset($arr['order_by'])) $DB->orderBy($arr['order_by']['field'], $arr['order_by']['order']);
        if (isset($arr['group_by'])) $DB->groupBy($arr['group_by']);

        $data = $DB->get()->getResultArray();

        switch ($arr['type']) {
            case 'json':
                $this->SuccessRespon('Data Berhasil Diambil', $data);
                break;
            case 'array':
                return $data;
                break;
        }
    }
    public function getGenre($jse)
    {
        $data = [];
        $jsd = json_decode($jse) ? json_decode($jse) : [];
        foreach ($jsd as $id) {
            $m = $this->db->table('video_genre')
                ->select('video_genre_id, video_genre_nama')
                ->where('video_genre_id', $id)
                ->get()
                ->getRowArray();
            $data[] = $m;
        }
        return $data;
    }
    public function getIdentitasWeb()
    {
        return $this->db->table('identitas_web')
            ->where('identitas_web_id', 1)
            ->get()
            ->getRowArray();
    }
    public function identitasWebSave($data)
    {
        $data['updated_time'] = date('Y-m-d H:i:s');
        $this->db->table('identitas_web')
            ->where('identitas_web_id', 1)
            ->set($data)
            ->update();
        $history = $this->historyCrud('update', ['table' => 'identitas_web', 'id' => 1, 'data' => $data]);
        return $history;
    }

    public function getPagesForm($id)
    {
        return $this->db->table('pages')
            ->select('pages_template_id, pages_nama, pages_isi, pages_id')
            ->where('pages_id', $id)
            ->get()->getRowArray();
    }
    public function pagesSave($data)
    {
        $id = $data['pages_id'];
        unset($data['pages_id']);

        if ($id) {
            $data['updated_time'] = date('Y-m-d H:i:s');
            $this->db->table('pages')
                ->where('pages_id', $id)
                ->set($data)
                ->update();
            $history = $this->historyCrud('update', ['table' => 'pages', 'id' => $id, 'data' => $data]);
        } else {
            $data['created_time'] = date('Y-m-d H:i:s');
            $this->db->table('pages')
                ->set($data)
                ->insert();
            $history = $this->historyCrud('insert', ['table' => 'pages', 'data' => $data]);
        }

        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }
    public function pagesDel($id)
    {
        $this->db->table('pages')
            ->where('pages_id', $id)
            ->delete();
        $history = $this->historyCrud('delete', ['table' => 'pages', 'id' => $id]);
        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }

    public function getMenuManagementForm($id)
    {
        return $this->db->table('menu_landing')
            ->select('menu_landing_id, menu_landing_nama, menu_landing_link, menu_landing_parent, menu_landing_urutan')
            ->where('menu_landing_id', $id)
            ->get()->getRowArray();
    }
    public function menuManagementSave($data)
    {
        $id = $data['menu_landing_id'];
        unset($data['menu_landing_id']);

        if ($id) {
            $data['updated_time'] = date('Y-m-d H:i:s');
            $this->db->table('menu_landing')
                ->where('menu_landing_id', $id)
                ->set($data)
                ->update();
            $history = $this->historyCrud('update', ['table' => 'menu_landing', 'id' => $id, 'data' => $data]);
        } else {
            $data['created_time'] = date('Y-m-d H:i:s');
            $this->db->table('menu_landing')
                ->set($data)
                ->insert();
            $history = $this->historyCrud('insert', ['table' => 'menu_landing', 'data' => $data]);
        }

        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }
    public function menuManagementDel($id)
    {
        $this->db->table('menu_landing')
            ->where('menu_landing_id', $id)
            ->delete();
        $history = $this->historyCrud('delete', ['table' => 'menu_landing', 'id' => $id]);
        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }
    public function statistikWebsite($arr)
    {
        //Cek Apakah Sudah Ada
        $i = $this->db->table('statistik')
            ->select('statistik_count')
            ->like('created_time', explode(' ', $arr['created_time'])[0])
            ->where('statistik_ip', $arr['statistik_ip'])
            ->get()
            ->getRow();

        //Insert or Update
        if (@$i->statistik_count) {
            $this->db->table('statistik')
                ->where('statistik_ip', $arr['statistik_ip'])
                ->like('created_time', explode(' ', $arr['created_time'])[0])
                ->set(['statistik_count' => $i->statistik_count + 1, 'updated_time' => date('Y-m-d H:i:s')])
                ->update();
        } else {
            $this->db->table('statistik')
                ->set($arr)
                ->insert();
        }

        return true;
    }
    public function getStatistikChart($date)
    {
        return $this->db->table('statistik')
            ->selectSum('statistik_count')
            ->like('created_time', $date)
            ->get()
            ->getRow();
    }
}
