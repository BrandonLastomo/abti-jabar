@extends('layouts.master')

@section('title', 'Archives')

@section('content')
<div>
	<div class="section">
		<div class="sectionHead">
			<div>
				<h2>Archives</h2>
				<p></p>
			</div>
			<div class="pill">archives.*</div>
		</div>

		<div class="sectionBody">

			<h3 style="margin:0 0 10px;">Header</h3>
			<div class="grid2">
				<div class="field">
					<label>Eyebrow</label>
					<input type="text" name="ar_head_eyebrow"
						value=""
						placeholder="ABTI Jawa Barat">
				</div>

				<div class="field">
					<label>Title</label>
					<input type="text" name="ar_head_title"
						value=""
						placeholder="Archives">
				</div>

				<div class="field" style="grid-column:1/-1;">
					<label>Subtitle</label>
					<textarea name="ar_head_sub" placeholder="Kumpulan dokumen regulasi resmi..."></textarea>
				</div>
			</div>

			<div class="divider"></div>

			<h3 style="margin:0 0 10px;">Kategori Accordion (5)</h3>

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
				Saran: isi nama dokuman sesuai nama PDF
			</div>

		</div>
	</div>
</div>

<div class="actions">
	<button id="saveBtn" class="btn primary" type="submit">Save Changes</button>
</div>
@endsection