<?php

namespace App\Http\Requests\Admin\Penduduk;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdatePendudukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation(): void
    {
        $this->request->replace($this
            ->only([
                'NIK',
                'NKK',
                'nama',
                'tgl_lahir',
                'pendapatan',
                'no_telp',
                'jenis_kelamin',
                'pendidikan',
                'hubungan_keluarga',
                'alamat',
                'RT',
                'penduduk',
            ])
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'NIK' => [
                'bail',
                'required',
                'string',
                'regex:/^\w{16,20}$/',
                'unique:penduduks,NIK, '.$this->route('penduduk').',penduduk_id',
            ],
            'NKK'=> [
                'bail',
                'required',
                'string',
                'regex:/^\w{16,20}$/',
            ],
            'nama' => [
                'bail',
                'required',
                'string',
                'regex:/^[a-zA-Z\s.]{1,100}$/',
            ],
            'tgl_lahir' => [
                'bail',
                'required',
                'date_format:Y-m-d'
            ],
            'pendapatan' => [
                'bail',
                'required',
                Rule::in(['Belum Bekerja', 'Rp 0 - Rp 500.000', 'Rp 500.000 - Rp 1.000.000', 'Rp 1.000.000 - Rp 2.000.000', 'Rp 2.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Keatas'])
            ],
            'no_telp' =>[
                'bail',
                'nullable',
                'string',
                'regex:/^\w{0,14}$/',
            ],
            'jenis_kelamin' => [
                'bail',
                'required',
                Rule::in(['L', 'P'])
            ],
            'pendidikan' => [
                'bail',
                'required',
                Rule::in(['Belum Sekolah', 'Tidak Terpelajar', 'SD', 'SMP', 'SMA/SMK', 'D4/S1', 'S2 Keatas'])
            ],
            'hubungan_keluarga' => [
                'bail',
                'required',
                Rule::in(['Kepala Keluarga', 'Istri', 'Anak']),
                function ($attribute, $value, $fail) {
                    if (
                        $value !== 'Anak'and
                        DB::table('penduduks')
                            ->where('hubungan_keluarga', $value)
                            ->where('NKK', '=', $this->input('NKK'))
                            ->where('penduduk_id', '!=', $this->route('penduduk'))
                            ->exists()
                    ) {
                        $fail("$value dalam satu KK maksimal 1 dan sudah ada datanya!");
                    }
                }
            ],
            'alamat' => [
                'bail',
                'required',
                'string',
                'regex:/^([\w\s\n.]{1,200})$/',
            ],
            'RT' => [
                'bail',
                'required',
                Rule::in(['RT 01', 'RT 02', 'RT 03', 'RT 04', 'RT 05', 'RT 06'])
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            /**
             * costum message for NIK column or field input
             */
            'NIK.required' => 'NIK harus di isi!',
            'NIK.string' => 'NIK harus berupa string!',
            'NIK.regex' => 'NIK minimal 16 dan maksimal 20 angka!',
            'NIK.unique' => 'NIK harus unik antara penduduk lain!',
            /**
             * costum message for NKK column or field input
             */
            'NKK.required' => 'NKK harus di isi!',
            'NKK.string' => 'NKK harus berupa string!',
            'NKK.regex' => 'NKK minimal 16 dan maksimal 20 angka!',
            /**
             * costum message for nama column or field input
             */
            'nama.required' => 'nama harus di isi!',
            'nama.string' => 'nama harus berupa string!',
            'nama.regex' => 'nama maksimal 100 serta hanya boleh huruf dan tanda .!',
            /**
             * costum message for tgl_lahir column or field input
             */
            'tgl_lahir.required' => 'tanggal lahir harus di isi!',
            'tgl_lahir.date_format' => "tanggal lahir harus valid dengan format: Tahun-Bulan-Tanggal !",
            /**
             * costum message for no_telp column or field input
             */
            'no_telp.string' => 'nomor telepon harus berupa string!',
            'no_telp.regex' => 'nomor telepon maksimal 14 angka!',
            /**
             * costum message for alamat column or field input
             */
            'alamat.required' => 'alamat harus di isi!',
            'alamat.string' => 'alamat harus berupa string!',
            'alamat.regex' => 'alamat maksimal 200 kata!',
            /**
             * costum message for pendapatan column or field input
             */
            'pendapatan.required' => 'pendapatan harus di isi!',
            /**
             * costum message for pendidikan column or field input
             */
            'pendidikan.required' => 'pendidikan harus di isi!',
            /**
             * costum message for hubungan_keluarga column or field input
             */
            'hubungan_keluarga.required' => 'hubungan keluarga harus di isi!',
            /**
             * costum message for RT column or field input
             */
            'RT.required' => 'RT harus di isi!',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        /**
         * compare updated data from user form with old data in
         * database and just replace request input with data that
         * changes
         */
        $oldData = json_decode($this->input('penduduk'), true);

        $this->request->replace($this->only(array_keys(array_diff_assoc($oldData, $this->request->all()))));
    }

}
