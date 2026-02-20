@extends('layouts.master')

@section('title', 'Program Kerja')

@section('content')
<div>
	<div class="section">
		<div class="sectionHead">
			<div>
				<h2>Program Kerja</h2>
				<p></p>
			</div>
			<div class="pill">{{$programKerja->count()}} items</div>
		</div>

		{{-- SUCCESS MESSAGE --}}
		@if(session('success'))
		<div style="color:green; margin-bottom:15px;">
			{{ session('success') }}
		</div>
		@endif
		<div class="sectionBody">
			<div class="cardGrid">
				<div class="table-wrapper">
					<table class="custom-table">
						<thead>
							<tr>
								<th>Title</th>
								<th>Hero Meta</th>
								<th>Category</th>
								<th>Year</th>
								<th>Desc</th>
								<th>Image</th>
							</tr>
						</thead>
						<tbody>
							@foreach($programKerja as $item)
							<tr>
								<td>{{ $item['title'] }}</td>
								<td>{{ $item['hero_meta'] }}</td>
								<td>{{ $item['category'] }}</td>
								<td>
									@if($item['image'])
									<span class="status uploaded">Uploaded</span>
									@else
									<span class="status not-uploaded">Not Uploaded</span>
									@endif
								</td>
								<td>{{ $item['year'] }}</td>
								<td>{{ $item['desc'] }}</td>
								<td class="actions">
									<a href="{{ route('program-kerja.show', $item['slug']) }}" class="btn btn-view">View</a> <a href="{{ route('program-kerja.edit', $item['slug']) }}" class="btn btn-edit">Edit</a>

									<form id="deleteForm{{ $item->id }}"
										action="{{ route('program-kerja.destroy', $item) }}"
										method="POST"
										style="display:inline;">
										@csrf
										@method('DELETE')

										<button type="button"
											class="btn btn-delete"
											onclick="showAlert(
                                                'Hapus Data',
                                                'Data ini akan dihapus permanen.',
                                                function() {
                                                    document.getElementById('deleteForm{{ $item->id }}').submit();
                                                }
                                            )">
											Delete
										</button>
									</form>


								</td>
							</tr>
							@endforeach
						</tbody>




					</table>
				</div>
			</div>
			{{-- Pagination --}}
			<div class="table-bottom">
			  <div class="pagination-custom">
		
				@if ($programKerja->onFirstPage())
				  <span class="disabled">&lt;</span>
				@else
				  <a href="{{ $programKerja->previousPageUrl() }}">&lt;</a>
				@endif
		
				@for ($i = 1; $i <= $programKerja->lastPage(); $i++)
				  @if ($i == $programKerja->currentPage())
					<span class="active">{{ $i }}</span>
				  @else
					<a href="{{ $programKerja->url($i) }}">{{ $i }}</a>
				  @endif
				@endfor
		
				@if ($programKerja->hasMorePages())
				  <a href="{{ $programKerja->nextPageUrl() }}">&gt;</a>
				@else
				  <span class="disabled">&gt;</span>
				@endif
		
			  </div>
			</div>
		</div>
	</div>
</div>


<div class="actions">
	<a href="{{ route('program-kerja.create') }}" id="saveBtn" class="btn primary" type="submit">Add Program Kerja</a>
</div>



<div id="customAlert" class="alert-overlay">
	<div class="alert-box">
		<h3 id="alertTitle">Konfirmasi</h3>
		<p id="alertMessage">Yakin mau hapus data ini?</p>

		<div class="alert-actions">
			<button id="cancelBtn" class="btn btn-edit">Batal</button>
			<button id="confirmBtn" class="btn btn-delete">Hapus</button>
		</div>
	</div>
</div>

<script>
let confirmCallback = null;

const alertBox   = document.getElementById('customAlert');
const alertTitle = document.getElementById('alertTitle');
const alertMsg   = document.getElementById('alertMessage');
const cancelBtn  = document.getElementById('cancelBtn');
const confirmBtn = document.getElementById('confirmBtn');

function showAlert(title, message, callback = null) {

    alertTitle.innerText = title;
    alertMsg.innerText   = message;

    confirmCallback = callback;

    confirmBtn.innerText = 'Hapus';
    confirmBtn.classList.remove('loading');

    alertBox.style.display = 'flex';
}

cancelBtn.onclick = function () {
    alertBox.style.display = 'none';
};

confirmBtn.onclick = function () {

    confirmBtn.classList.add('loading');
    confirmBtn.innerText = 'Menghapus...';

    setTimeout(() => {

        if (typeof confirmCallback === "function") {
            confirmCallback();
        }

    }, 600);
};
</script>

@endsection
