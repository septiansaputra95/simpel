@extends('layouts.newlayout')
@section('newcontent')

<!-- ================= HEADER ================= -->
    <h1 class="font-bold text-lg mb-1">
        Form Master Pasien
    </h1>

    <p class="text-sm text-muted mb-6">
        Lengkapi data pasien untuk registrasi baru.
    </p>


    <!-- ================= INFO BOX ================= -->
    <div class="flex items-start gap-3 bg-accent-bg border border-accent-bg rounded-xl px-4 py-3 mb-6">

        <i class="bi bi-info-circle-fill text-accent mt-0.5"></i>

        <div>
            <div class="text-sm font-semibold text-accent">
                Kolom bertanda <span class="text-danger">*</span> wajib diisi
            </div>

            <div class="text-xs text-accent/80">
                Pastikan nomor identitas dan BPJS ID sesuai dokumen resmi pasien.
            </div>
        </div>

    </div>


    <form id="formMasterPasien" class="space-y-6">
        @csrf

        <!-- ===================================================== -->
        <!-- INFORMASI REGISTRASI -->
        <!-- ===================================================== -->

        <div class="bg-white border border-bd rounded-2xl overflow-hidden">

            <!-- Header Section -->
            <div class="flex items-center gap-3 px-6 py-4 border-b border-bd">

                <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-blue-bg text-blue">
                    <i class="bi bi-clipboard2-pulse"></i>
                </span>

                <h2 class="font-bold text-[15px]">
                    Informasi Registrasi
                </h2>

            </div>


            <!-- Form -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-x-5 gap-y-5">


                <!-- MRN -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        MRN
                    </label>

                    <input
                        type="text"
                        name="mrn"
                        value="{{ $newMrn }}"
                        readonly
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Registration Type -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Registration Type
                    </label>

                    <select
                        name="registration_type"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="Rawat Jalan">Rawat Jalan</option>
                        <option value="Rawat Inap">Rawat Inap</option>
                        <option value="IGD">IGD</option>

                    </select>

                </div>


                <!-- Registration Date -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Registration Date<span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="registration_date"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Service Center -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Service Center
                    </label>

                    <select
                        name="service_center"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="Poli Umum">Poli Umum</option>
                        <option value="Poli Anak">Poli Anak</option>
                        <option value="Poli Gigi">Poli Gigi</option>

                    </select>

                </div>


                <!-- User -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        User
                    </label>

                    <input
                        type="text"
                        name="user"
                        value="{{ auth()->user()->nama }}"
                        readonly
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Plan Name -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Plan Name
                    </label>

                    <select
                        name="plan_name"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="Umum">Umum</option>
                        <option value="BPJS">BPJS</option>
                        <option value="Asuransi Swasta">Asuransi Swasta</option>

                    </select>

                </div>

            </div>

        </div>



        <!-- ===================================================== -->
        <!-- DATA PASIEN -->
        <!-- ===================================================== -->

        <div class="bg-white border border-bd rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="flex items-center gap-3 px-6 py-4 border-b border-bd">

                <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-teal-bg text-teal">
                    <i class="bi bi-person-badge-fill"></i>
                </span>

                <h2 class="font-bold text-[15px]">
                    Data Pasien
                </h2>

            </div>


            <!-- Form -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-x-5 gap-y-5">


                <!-- Patient Name -->
                <div class="md:col-span-2">

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Patient Name
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="patientname"
                        placeholder="Nama lengkap pasien"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Gender -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Gender
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="gender"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>

                    </select>

                </div>


                <!-- Date of Birth -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Date of Birth
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="dateofbirth"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Marital Status -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Marital Status
                    </label>

                    <select
                        name="marital_status"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="Belum Menikah">Belum Menikah</option>
                        <option value="Menikah">Menikah</option>
                        <option value="Cerai">Cerai</option>

                    </select>

                </div>


                <!-- Religion -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Religion
                    </label>

                    <select
                        name="religion"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>

                    </select>

                </div>


                <!-- Nationality -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Nationality
                    </label>

                    <input
                        type="text"
                        name="nationality"
                        value="Indonesia"
                        placeholder="Contoh: Indonesia"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>

            </div>

        </div>



        <!-- ===================================================== -->
        <!-- KONTAK & ALAMAT -->
        <!-- ===================================================== -->

        <div class="bg-white border border-bd rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="flex items-center gap-3 px-6 py-4 border-b border-bd">

                <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-bg text-amber">
                    <i class="bi bi-geo-alt-fill"></i>
                </span>

                <h2 class="font-bold text-[15px]">
                    Kontak &amp; Alamat
                </h2>

            </div>


            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-x-5 gap-y-5">


                <!-- Mobile -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Mobile No
                    </label>

                    <input
                        type="text"
                        name="mobile_no"
                        placeholder="08xxxxxxxxxx"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Phone -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Phone No
                    </label>

                    <input
                        type="text"
                        name="phone_no"
                        placeholder="(0285) xxxxxxx"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Address -->
                <div class="md:col-span-3">

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Address
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="address"
                        placeholder="Nama jalan, nomor rumah, RT/RW"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- City -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        City
                    </label>

                    <input
                        type="text"
                        name="city"
                        placeholder="Kota"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- District -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        District
                    </label>

                    <input
                        type="text"
                        name="district"
                        placeholder="Kecamatan"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- State -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        State
                    </label>

                    <input
                        type="text"
                        name="state"
                        placeholder="Provinsi"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Country -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Country
                    </label>

                    <input
                        type="text"
                        name="country"
                        value="Indonesia"
                        placeholder="Negara"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>

            </div>

        </div>



        <!-- ===================================================== -->
        <!-- IDENTITAS & JAMINAN -->
        <!-- ===================================================== -->

        <div class="bg-white border border-bd rounded-2xl overflow-hidden">

            <div class="flex items-center gap-3 px-6 py-4 border-b border-bd">

                <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-bg text-rose">
                    <i class="bi bi-card-heading"></i>
                </span>

                <h2 class="font-bold text-[15px]">
                    Identitas &amp; Jaminan
                </h2>

            </div>


            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-x-5 gap-y-5">


                <!-- Identity Type -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Identity Type
                    </label>

                    <select
                        name="identity_type"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="KTP">KTP</option>
                        <option value="SIM">SIM</option>
                        <option value="Paspor">Paspor</option>
                        <option value="KIA">KIA</option>

                    </select>

                </div>


                <!-- Identity No -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Identity No
                    </label>

                    <input
                        type="text"
                        name="identity_no"
                        placeholder="Nomor identitas"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- BPJS -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        BPJS ID
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        name="idbpjs"
                        placeholder="Nomor kepesertaan BPJS"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>

            </div>

        </div>



        <!-- ===================================================== -->
        <!-- KONTAK DARURAT -->
        <!-- ===================================================== -->

        <div class="bg-white border border-bd rounded-2xl overflow-hidden">

            <div class="flex items-center gap-3 px-6 py-4 border-b border-bd">

                <span class="w-8 h-8 rounded-lg flex items-center justify-center bg-red-bg text-danger">
                    <i class="bi bi-telephone-forward-fill"></i>
                </span>

                <h2 class="font-bold text-[15px]">
                    Kontak Darurat
                </h2>

            </div>


            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-x-5 gap-y-5">


                <!-- Contact Person -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Emergency Contact Person
                    </label>

                    <input
                        type="text"
                        name="emergency_contact"
                        placeholder="Nama kontak darurat"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>


                <!-- Relationship -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Relationship
                    </label>

                    <select
                        name="emergency_relationship"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               bg-white outline-none
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                        <option value="">-- Pilih --</option>
                        <option value="Orang Tua">Orang Tua</option>
                        <option value="Suami/Istri">Suami/Istri</option>
                        <option value="Anak">Anak</option>
                        <option value="Saudara">Saudara</option>
                        <option value="Lainnya">Lainnya</option>

                    </select>

                </div>


                <!-- Emergency Phone -->
                <div>

                    <label class="block text-xs font-semibold text-ink mb-2">
                        Emergency Phone No
                    </label>

                    <input
                        type="text"
                        name="emergency_phone"
                        placeholder="08xxxxxxxxxx"
                        class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm
                               outline-none
                               placeholder:text-slate-300
                               focus:ring-2 focus:ring-accent-bg
                               focus:border-accent">

                </div>

            </div>

        </div>



        <!-- ===================================================== -->
        <!-- FOOTER ACTION -->
        <!-- ===================================================== -->

        <div class="flex items-center justify-between bg-white border border-bd rounded-2xl px-6 py-4">

            <span class="text-xs text-muted">
                <span class="text-danger">*</span>
                Kolom wajib diisi sebelum data dapat disimpan
            </span>


            <div class="flex gap-3">

                <button
                    type="button"
                    class="border border-bd text-slate-600 font-semibold text-sm
                           rounded-lg px-5 py-2.5
                           hover:bg-slate-50">

                    Batal

                </button>


                <button
                    type="submit"
                    class="{{ $buttonColor }} hover:opacity-90 text-white font-semibold text-sm
                           rounded-lg px-6 py-2.5">

                    <i class="bi bi-check-lg mr-1"></i>
                    {{ $buttonName }}

                </button>

            </div>

        </div>

    </form>

@push('scripts')
@vite('resources/js/master/masterpasien.js')
@endpush
@endsection