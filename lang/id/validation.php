<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'        => 'field atau inputan harus diterima.',
    'active_url'      => 'field atau inputan bukan URL yang valid.',
    'after'           => 'field atau inputan harus berisi tanggal setelah :date.',
    'after_or_equal'  => 'field atau inputan harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'           => 'field atau inputan hanya boleh berisi huruf.',
    'alpha_dash'      => 'field atau inputan hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'       => 'field atau inputan hanya boleh berisi huruf dan angka.',
    'array'           => 'field atau inputan harus berisi sebuah array.',
    'before'          => 'field atau inputan harus berisi tanggal sebelum :date.',
    'before_or_equal' => 'field atau inputan harus berisi tanggal sebelum atau sama dengan :date.',
    'between'         => [
        'numeric' => 'field atau inputan harus bernilai antara :min sampai :max.',
        'file'    => 'field atau inputan harus berukuran antara :min sampai :max kilobita.',
        'string'  => 'field atau inputan harus berisi antara :min sampai :max karakter.',
        'array'   => 'field atau inputan harus memiliki :min sampai :max anggota.',
    ],
    'boolean'        => 'field atau inputan harus bernilai true atau false',
    'confirmed'      => 'Konfirmasi field atau inputan tidak cocok.',
    'date'           => 'field atau inputan bukan tanggal yang valid.',
    'date_equals'    => 'field atau inputan harus berisi tanggal yang sama dengan :date.',
    'date_format'    => 'field atau inputan tidak cocok dengan format :format.',
    'different'      => 'field atau inputan dan :other harus berbeda.',
    'digits'         => 'field atau inputan harus terdiri dari :digits angka.',
    'digits_between' => 'field atau inputan harus terdiri dari :min sampai :max angka.',
    'dimensions'     => 'field atau inputan tidak memiliki dimensi gambar yang valid.',
    'distinct'       => 'field atau inputan memiliki nilai yang duplikat.',
    'email'          => 'field atau inputan harus berupa alamat surel yang valid.',
    'ends_with'      => 'field atau inputan harus diakhiri salah satu dari berikut: :values',
    'exists'         => 'field atau inputan yang dipilih tidak valid.',
    'file'           => 'field atau inputan harus berupa sebuah berkas.',
    'filled'         => 'field atau inputan harus memiliki nilai.',
    'gt'             => [
        'numeric' => 'field atau inputan harus bernilai lebih besar dari :value.',
        'file'    => 'field atau inputan harus berukuran lebih besar dari :value kilobita.',
        'string'  => 'field atau inputan harus berisi lebih besar dari :value karakter.',
        'array'   => 'field atau inputan harus memiliki lebih dari :value anggota.',
    ],
    'gte' => [
        'numeric' => 'field atau inputan harus bernilai lebih besar dari atau sama dengan :value.',
        'file'    => 'field atau inputan harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'string'  => 'field atau inputan harus berisi lebih besar dari atau sama dengan :value karakter.',
        'array'   => 'field atau inputan harus terdiri dari :value anggota atau lebih.',
    ],
    'image'    => 'field atau inputan harus berupa gambar.',
    'in'       => 'field atau inputan yang dipilih tidak valid.',
    'in_array' => 'field atau inputan tidak ada di dalam :other.',
    'integer'  => 'field atau inputan harus berupa bilangan bulat.',
    'ip'       => 'field atau inputan harus berupa alamat IP yang valid.',
    'ipv4'     => 'field atau inputan harus berupa alamat IPv4 yang valid.',
    'ipv6'     => 'field atau inputan harus berupa alamat IPv6 yang valid.',
    'json'     => 'field atau inputan harus berupa JSON string yang valid.',
    'lt'       => [
        'numeric' => 'field atau inputan harus bernilai kurang dari :value.',
        'file'    => 'field atau inputan harus berukuran kurang dari :value kilobita.',
        'string'  => 'field atau inputan harus berisi kurang dari :value karakter.',
        'array'   => 'field atau inputan harus memiliki kurang dari :value anggota.',
    ],
    'lte' => [
        'numeric' => 'field atau inputan harus bernilai kurang dari atau sama dengan :value.',
        'file'    => 'field atau inputan harus berukuran kurang dari atau sama dengan :value kilobita.',
        'string'  => 'field atau inputan harus berisi kurang dari atau sama dengan :value karakter.',
        'array'   => 'field atau inputan harus tidak lebih dari :value anggota.',
    ],
    'max' => [
        'numeric' => 'field atau inputan maskimal bernilai :max.',
        'file'    => 'field atau inputan maksimal berukuran :max kilobita.',
        'string'  => 'field atau inputan maskimal berisi :max karakter.',
        'array'   => 'field atau inputan maksimal terdiri dari :max anggota.',
    ],
    'mimes'     => 'field atau inputan harus berupa berkas berjenis: :values.',
    'mimetypes' => 'field atau inputan harus berupa berkas berjenis: :values.',
    'min'       => [
        'numeric' => 'field atau inputan minimal bernilai :min.',
        'file'    => 'field atau inputan minimal berukuran :min kilobita.',
        'string'  => 'field atau inputan minimal berisi :min karakter.',
        'array'   => 'field atau inputan minimal terdiri dari :min anggota.',
    ],
    'not_in'               => 'field atau inputan yang dipilih tidak valid.',
    'not_regex'            => 'Format field atau inputan tidak valid.',
    'numeric'              => 'field atau inputan harus berupa angka.',
    'password'             => 'Kata sandi salah.',
    'present'              => 'field atau inputan wajib ada.',
    'regex'                => 'Format field atau inputan tidak valid.',
    'required'             => 'field atau inputan wajib diisi.',
    'required_if'          => 'field atau inputan wajib diisi bila :other adalah :value.',
    'required_unless'      => 'field atau inputan wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => 'field atau inputan wajib diisi bila terdapat :values.',
    'required_with_all'    => 'field atau inputan wajib diisi bila terdapat :values.',
    'required_without'     => 'field atau inputan wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'field atau inputan wajib diisi bila sama sekali tidak terdapat :values.',
    'same'                 => 'field atau inputan dan :other harus sama.',
    'size'                 => [
        'numeric' => 'field atau inputan harus berukuran :size.',
        'file'    => 'field atau inputan harus berukuran :size kilobyte.',
        'string'  => 'field atau inputan harus berukuran :size karakter.',
        'array'   => 'field atau inputan harus mengandung :size anggota.',
    ],
    'starts_with' => 'field atau inputan harus diawali salah satu dari berikut: :values',
    'string'      => 'field atau inputan harus berupa string.',
    'timezone'    => 'field atau inputan harus berisi zona waktu yang valid.',
    'unique'      => 'field atau inputan sudah ada sebelumnya.',
    'uploaded'    => 'field atau inputan gagal diunggah.',
    'url'         => 'Format field atau inputan tidak valid.',
    'uuid'        => 'field atau inputan harus merupakan UUID yang valid.',

    /*
    |---------------------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi Kustom
    |---------------------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi untuk atribut sesuai keinginan dengan menggunakan
    | konvensi "attribute.rule" dalam penamaan barisnya. Hal ini mempercepat dalam menentukan
    | baris bahasa kustom yang spesifik untuk aturan atribut yang diberikan.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |---------------------------------------------------------------------------------------
    | Kustom Validasi Atribut
    |---------------------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar 'placeholder' atribut dengan sesuatu yang
    | lebih mudah dimengerti oleh pembaca seperti "Alamat Surel" daripada "surel" saja.
    | Hal ini membantu kita dalam membuat pesan menjadi lebih ekspresif.
    |
    */

    'attributes' => [
    ],

];
