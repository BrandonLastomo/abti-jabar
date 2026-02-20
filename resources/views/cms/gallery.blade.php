@extends('layouts.master')

@section('title', 'Gallery')

@section('content')
<div>

	<div class="section">
		<div class="sectionHead">
			<div>
				<h2>Galeri Kegiatan (IHF)</h2>
				<p></p>
			</div>
			<div class="pill">gallery.*</div>
		</div>

		<div class="sectionBody">

			<!-- HEADER -->
			<h3 style="margin:0 0 10px;">Header</h3>
			<div class="grid2">
				<div class="field">
					<label>Header Title (Black)</label>
					<input type="text" name="gal_head_black"
						value="tes123"
						placeholder="Galeri Kegiatan">
				</div>

				<div class="field">
					<label>Header Title (Red)</label>
					<input type="text" name="gal_head_red"
						value=""
						placeholder="ABTI Jawa Barat">
				</div>

				<div class="field" style="grid-column: 1 / -1;">
					<label>Header Subtitle</label>
					<textarea name="gal_head_sub"
						placeholder="Ikuti perjalanan ABTI Jawa Barat..."></textarea>
				</div>
			</div>

			<div class="divider"></div>

			<!-- ITEMS -->
			<h3 style="margin:0 0 10px;">Kegiatan (10) • Foto per kegiatan (10)</h3>

			<div class="cardGrid">
				<div class="table-wrapper">
					<table class="custom-table">
						<thead>
							<tr>
								<th>Title</th>
								<th>Link</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bignews as $item)
							<tr>
								<td>{{ $item['title'] }}</td>
								<td>
									<a href="{{ $item['link'] }}">{{ $item['link'] }}</a>
								</td>
								<td>
									@if($item['image'])
									<span class="status uploaded">Uploaded</span>
									@else
									<span class="status not-uploaded">Not Uploaded</span>
									@endif
								</td>
								<td class="actions">
									<a href="{{ route('viewBignews.index') }}" class="btn btn-view">View</a> <a href="{{ route('editBignews.index') }}" class="btn btn-edit">Edit</a>

									<form id="deleteForm{{ $loop->index }}"
										action="{{ route('big_news.destroy', $loop->index) }}"
										method="POST">
										@csrf
										@method('DELETE')

										<button type="button"
											class="btn btn-delete"
											onclick="showAlert(
                      'Hapus Data',
                      'Data ini akan dihapus permanen.',
                      function() {
                          document.getElementById('deleteForm{{ $loop->index }}').submit();
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

			<div class="note">
				Saran: foto galeri <i>maksimal 200kb.</i> Convert ke webp untuk hasil maksimal.
			</div>

		</div>
	</div>
</div>

<div class="actions">
	<button id="saveBtn" class="btn primary" type="submit">Save Changes</button>
</div>
@endsection