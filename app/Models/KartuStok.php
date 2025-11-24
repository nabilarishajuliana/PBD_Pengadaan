<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KartuStok extends Model
{
    protected $table = 'kartu_stok';
    protected $primaryKey = 'idkartu_stok';
    public $timestamps = false;

    // ✨ Ambil semua kartu stok (dengan filter opsional)
    public static function getAllKartuStok($idbarang = null, $jenis_transaksi = null, $tanggal_dari = null, $tanggal_sampai = null)
    {
        $sql = "
            SELECT 
                k.idkartu_stok,
                k.jenis_transaksi,
                k.masuk,
                k.keluar,
                k.stock,
                k.created_at,
                k.idtransaksi,
                k.idbarang,
                b.nama AS nama_barang,
                s.nama_satuan,
                CASE 
                    WHEN k.jenis_transaksi = 'M' THEN 'Masuk (Penerimaan)'
                    WHEN k.jenis_transaksi = 'K' THEN 'Keluar (Penjualan)'
                    WHEN k.jenis_transaksi = 'R' THEN 'Retur ke Vendor'
                    ELSE 'Lainnya'
                END AS jenis_transaksi_label
            FROM kartu_stok k
            JOIN barang b ON k.idbarang = b.idbarang
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE 1=1
        ";

        $params = [];

        // Filter by barang
        if ($idbarang) {
            $sql .= " AND k.idbarang = ?";
            $params[] = $idbarang;
        }

        // Filter by jenis transaksi
        if ($jenis_transaksi) {
            $sql .= " AND k.jenis_transaksi = ?";
            $params[] = $jenis_transaksi;
        }

        // Filter by tanggal dari
        if ($tanggal_dari) {
            $sql .= " AND DATE(k.created_at) >= ?";
            $params[] = $tanggal_dari;
        }

        // Filter by tanggal sampai
        if ($tanggal_sampai) {
            $sql .= " AND DATE(k.created_at) <= ?";
            $params[] = $tanggal_sampai;
        }

        $sql .= " ORDER BY k.created_at DESC, k.idkartu_stok DESC";

        return DB::select($sql, $params);
    }

    // ✨ Ambil kartu stok per barang (untuk detail per item)
    public static function getKartuStokByBarang($idbarang)
    {
        $sql = "
            SELECT 
                k.idkartu_stok,
                k.jenis_transaksi,
                k.masuk,
                k.keluar,
                k.stock,
                k.created_at,
                k.idtransaksi,
                CASE 
                    WHEN k.jenis_transaksi = 'M' THEN 'Masuk (Penerimaan)'
                    WHEN k.jenis_transaksi = 'K' THEN 'Keluar (Penjualan)'
                    WHEN k.jenis_transaksi = 'R' THEN 'Retur ke Vendor'
                    ELSE 'Lainnya'
                END AS jenis_transaksi_label
            FROM kartu_stok k
            WHERE k.idbarang = ?
            ORDER BY k.created_at DESC, k.idkartu_stok DESC
        ";

        return DB::select($sql, [$idbarang]);
    }

    // ✨ Ambil stok akhir per barang
    public static function getStokAkhirPerBarang()
    {
        $sql = "
            SELECT 
                b.idbarang,
                b.nama AS nama_barang,
                b.jenis,
                s.nama_satuan,
                COALESCE(SUM(k.masuk), 0) AS total_masuk,
                COALESCE(SUM(k.keluar), 0) AS total_keluar,
                COALESCE(SUM(k.masuk) - SUM(k.keluar), 0) AS stok_akhir,
                b.harga AS harga_beli
            FROM barang b
            LEFT JOIN kartu_stok k ON b.idbarang = k.idbarang
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE b.status = 1
            GROUP BY b.idbarang, b.nama, b.jenis, s.nama_satuan, b.harga
            ORDER BY b.nama ASC
        ";

        return DB::select($sql);
    }

    // ✨ Ambil info barang untuk filter
    public static function getBarangForFilter()
    {
        $sql = "
            SELECT 
                b.idbarang,
                b.nama,
                b.jenis
            FROM barang b
            WHERE b.status = 1
            ORDER BY b.nama ASC
        ";

        return DB::select($sql);
    }

    // ✨ Get detail barang
    public static function getBarangDetail($idbarang)
    {
        $sql = "
            SELECT 
                b.idbarang,
                b.nama AS nama_barang,
                b.jenis,
                s.nama_satuan,
                b.harga AS harga_beli,
                COALESCE(
                    (SELECT SUM(masuk - keluar) FROM kartu_stok WHERE idbarang = b.idbarang),
                    0
                ) AS stok_akhir
            FROM barang b
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE b.idbarang = ?
            LIMIT 1
        ";

        $res = DB::select($sql, [$idbarang]);
        return count($res) ? $res[0] : null;
    }
}