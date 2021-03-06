<?php

namespace App\Models;

class MUsers extends BaseModel
{
    public function getAuth($data)
    {
        $DB = $this->db->table('user as us');
        $DB->select('lv.user_level_id, lv.user_type, us.user_nama, us.email, us.password, us.user_img, us.user_id, us.is_active');
        $DB->join('user_level as lv', 'us.user_level_id=lv.user_level_id');
        $DB->where('us.email', $data['email']);
        $m = $DB->get()->getResultArray();
        return $m;
    }
    public function saveUsers($data)
    {
        $pass = $data['password'];
        unset($data['password']);

        $data['user_level_id'] = '2';
        $data['kode_otp'] = rand(111111, 999999);
        $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
        $data['created_time'] = date('Y-m-d H:i:s');
        $this->db->table('user')->set($data)->insert();
        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $data['kode_otp'];
    }
    public function getUserForm($uid)
    {
        $m = $this->db->table('user')
            ->select('user.user_nama, user.email, user.user_tgl_lahir, country.country_nama, country.country_id, user.is_active, user.user_img, user.user_id')
            ->join('country', 'country.country_id=user.country_id')
            ->where('user.user_id', $uid)
            ->get()
            ->getRowArray();
        if (!$m) return [];
        $dt['history'] = $this->getHistoryUser($m['user_id']);
        return array_merge($m, $dt);
    }
    public function getHistoryUser($uid)
    {
        $m = $this->db->table('history_user')
            ->where('user_id', $uid)
            ->orderBy('created_time', 'desc')
            ->limit('10')
            ->get()
            ->getResultArray();
        return $m;
    }
    public function usersBlock($uid)
    {
        $is_active = $uid['key'] == 'unblock' ? 1 : 2;
        $this->db->table('user')
            ->where('user_id', $uid['uid'])
            ->set(['is_active' => $is_active, 'updated_time' => date('Y-m-d H:i:s')])
            ->update();
        $history = $this->historyCrud($uid['key'], ['table' => 'user', 'id' => $uid['uid']]);
        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }
    public function adminSave($data)
    {
        $uid = $data['user_id'];
        $data['is_active'] = '1';
        $data['user_level_id'] = '1';
        $data['kode_otp'] = rand(111111, 999999);
        unset($data['user_id']);

        if ($uid) {
            if ($data['password'] == '') {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $data['updated_time'] = date('Y-m-d H:i:s');
            $this->db->table('user')
                ->where('user_id', $uid)
                ->set($data)
                ->update();
            $history = $this->historyCrud('update', ['table' => 'user', 'id' => $uid, 'data' => $data]);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['created_time'] = date('Y-m-d H:i:s');
            $this->db->table('user')
                ->set($data)
                ->insert();
            $history = $this->historyCrud('insert', ['table' => 'user', 'data' => $data]);
        }

        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }
    public function adminDel($uid)
    {
        $this->db->table('user')
            ->where('user_id', $uid)
            ->delete();
        $history = $this->historyCrud('delete', ['table' => 'user', 'id' => $uid]);
        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }
    public function getUserbyId($uid)
    {
        $data = $this->db->table('user as u')
            ->select('c.country_nama, u.email, u.user_img, u.user_nama, u.user_tgl_lahir, u.is_active, c.country_id , u.user_id')
            ->join('country as c', 'c.country_id=u.country_id')
            ->where('u.user_id', $uid)
            ->get()
            ->getRowArray();
        return $data;
    }
    public function getFavoriteUser($uid)
    {
        $data = $this->db->table('user_favorit as fav')
            ->select('v.video_nama, v.video_tahun, v.video_thumbnail, v.video_rating, v.video_dilihat, vg.video_genre_nama, v.video_id')
            ->join('video as v', 'v.video_id=fav.video_id')
            ->join('video_genre as vg', 'vg.video_genre_id=v.video_genre_id')
            ->where('fav.user_id', $uid)
            ->orderBy('fav.created_time', 'desc')
            ->get()
            ->getResultArray();
        return $data;
    }
    public function userProfileEdit($data)
    {
        $uid = $this->session->get('user_id');
        if (!$uid) $this->ErrorRespon('Akses anda ditolak..');
        $data['updated_time'] = date('Y-m-d');

        $this->db->table('user')
            ->where('user_id', $uid)
            ->set($data)
            ->update();
        $history = $this->historyCrud('update', ['table' => 'user', 'id' => $uid, 'data' => $data]);
        $i = $this->db->affectedRows();
        if (!$i) $this->ErrorRespon('Maaf Server Sedang Perbaikan..');
        return $history;
    }
}
