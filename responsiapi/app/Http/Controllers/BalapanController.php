<?php

namespace App\Http\Controllers;

use App\Models\Balapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BalapanController extends Controller
{
    public function index()
    {
        return Balapan::all();
    }

    public function store(Request $request)
    {
        try {
            // Validasi dengan pesan error yang lebih spesifik
            $validated = $request->validate([
                'nama_balapan' => 'required|string|max:255',
                'deskripsi' => 'nullable|string|max:1000',
            ], [
                'nama_balapan.required' => 'Nama balapan harus diisi',
                'nama_balapan.string' => 'Nama balapan harus berupa teks',
                'nama_balapan.max' => 'Nama balapan maksimal 255 karakter',
                'deskripsi.string' => 'Deskripsi harus berupa teks',
                'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
            ]);

            // Log data yang masuk
            Log::info('Data balapan yang diterima:', $validated);

            // Buat balapan
            $balapan = Balapan::create($validated);

            return response()->json($balapan, 201);
        } catch (ValidationException $e) {
            // Log error validasi
            Log::error('Validation Error:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log error umum
            Log::error('Error creating balapan:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Gagal membuat balapan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id_balap)
    {
        try {
            return Balapan::findOrFail($id_balap);
        } catch (\Exception $e) {
            Log::error('Error finding balapan:', [
                'id' => $id_balap,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Balapan tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id_balap)
    {
        try {
            // Validasi dengan pesan error yang lebih spesifik
            $validated = $request->validate([
                'nama_balapan' => 'required|string|max:255',
                'deskripsi' => 'nullable|string|max:1000',
            ], [
                'nama_balapan.required' => 'Nama balapan harus diisi',
                'nama_balapan.string' => 'Nama balapan harus berupa teks',
                'nama_balapan.max' => 'Nama balapan maksimal 255 karakter',
                'deskripsi.string' => 'Deskripsi harus berupa teks',
                'deskripsi.max' => 'Deskripsi maksimal 1000 karakter'
            ]);

            // Log data yang masuk
            Log::info('Data update balapan yang diterima:', [
                'id' => $id_balap,
                'data' => $validated
            ]);

            $balapan = Balapan::findOrFail($id_balap);
            $balapan->update($validated);

            return response()->json($balapan, 200);
        } catch (ValidationException $e) {
            // Log error validasi
            Log::error('Validation Error:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log error umum
            Log::error('Error updating balapan:', [
                'id' => $id_balap,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Gagal memperbarui balapan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id_balap)
    {
        try {
            // Log ID yang akan dihapus
            Log::info('Menghapus balapan:', ['id' => $id_balap]);

            $balapan = Balapan::findOrFail($id_balap);
            $balapan->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error menghapus balapan:', [
                'id' => $id_balap,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Gagal menghapus balapan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}