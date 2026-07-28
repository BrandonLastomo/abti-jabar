@extends('cms.layouts.master')

@section('title', 'Manage Documents - ' . $club->name)

@section('content')

<div>
  <div class="section">
    <div class="sectionHead">
      <div>
        <h2>Manage Documents: {{ $club->name }}</h2>
      </div>
      <div class="actions" style="margin-top:-20px; justify-content:flex-end;">
        <a href="{{ route('club.index') }}" class="btn" style="background:#64748b; color:white;">
            Back to Clubs
        </a>
      </div>
    </div>

    @if (session('success'))
        <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="color:red; margin-bottom:15px; margin-top:15px; background: #ffe6e6; padding: 10px; border: 1px solid red; border-radius: 5px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('club.documents.store', $club->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @php
            $fields = [
                'akta_notaris' => 'Akta Notaris',
                'badan_hukum' => 'Badan Hukum (SK Kemenkumham)',
                'npwp' => 'NPWP',
                'sk' => 'SK Kepengurusan',
                'ad_art' => 'AD / ART',
                'keorganisasian' => 'Surat Keterangan Keorganisasian',
                'keolahragaan' => 'Surat Keterangan Keolahragaan'
            ];
        @endphp

        <div class="form-wrapper" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
            
            @foreach($fields as $key => $label)
                <h3 style="margin-top: {{ $loop->first ? '0' : '30px' }}; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">{{ $label }}</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nomor / Keterangan</label>
                        <input type="text" name="{{ $key }}" value="{{ old($key, $document->$key ?? '') }}" placeholder="Masukkan Keterangan / Nomor" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tanggal Pembuatan</label>
                        <input type="date" name="{{ $key }}_date" value="{{ old($key.'_date', $document->{$key.'_date'} ?? '') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Upload Dokumen (PDF/Img)</label>
                        <input type="file" name="{{ $key }}_file" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        @if(isset($document->{$key.'_path'}) && $document->{$key.'_path'})
                            <div style="margin-top: 5px; font-size: 12px;">
                                <a href="{{ asset('storage/' . $document->{$key.'_path'}) }}" target="_blank" style="color: #3b82f6; display: inline-block; margin-bottom: 5px;">Lihat Dokumen Saat Ini</a>
                                <div>
                                    <x-verification-badge :model="$document" :field="$key.'_path'" />
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach

            <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                <button type="submit" class="btn primary" style="width: 100%; font-size: 16px; padding: 12px;">Save Documents</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection
