@extends('layouts.master')

@section('title', 'News Content')

@section('content')
<div>
	<div class="section">
		<div class="sectionHead">
			<div>
				<h2>West Java Corner</h2>
				<p></p>
			</div>
			<div class="pill">westjava.*</div>
		</div>

		<div class="sectionBody">

			<!-- <div class="field">
				<label>Link “Lihat semua update di YouTube”</label>
				<input type="text"
					name="wjc_youtube_all_url"
					value="Iyaya"
					placeholder="https://www.youtube.com/@CHANNEL_KAMU">
			</div> -->

			<!-- <div class="divider"></div> -->

			<h3 style="margin:0 0 10px;">Berita Terbaru ({{ $news->count() }})</h3>
			<div class="cardGrid">
				<div class="table-wrapper">
					<table class="custom-table">
						<thead>
							<tr>
								<th>Title</th>
								<th>Category</th>
								<th>Content</th>
								<th>CTA Text</th>
								<th>Youtube URL</th>
							</tr>
						</thead>
						<tbody>
							@foreach($news as $item)
							<tr>
								<td>{{ $item['title'] }}</td>
								<td>{{ $item['category'] }}</td>
								<td>{{ $item['content'] }}</td>
								<td>{{ $item['cta_text'] }}</td>
								<td>{{ $item['youtube_url'] }}</td>
								<td class="actions">
									<a href="{{ route('news-content.show', $item['slug']) }}" class="btn btn-view">View</a> <a href="{{ route('news-content.edit', $item['slug']) }}" class="btn btn-edit">Edit</a>

									<form id="deleteForm{{ $item->id }}"
										action="{{ route('news-content.destroy', $item) }}"
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
							</tr>
							@endforeach
						</tbody>




					</table>
				</div>
			</div>

			<div class="divider"></div>

			<h3 style="margin:0 0 10px;">Shorts Feed (maks 10)</h3>
			<div class="cardGrid">
				<div class="itemCard">
					<div class="itemTop">
						<b>Shorts #1</b>
						<span class="pill">westjava.shorts</span>
					</div>
					<div class="field">
						<label>URL</label>
						<input type="text" name="wjc_shorts_url_1"
							value=""
							placeholder="https://www.youtube.com/shorts/...">
					</div>
				</div>

			</div>

			<div class="note">
				Catatan: link youtube wajib disertakan lengkap <i>dengan https://...</i>.
			</div>

		</div>
	</div>
</div>

<div class="actions">
	<button id="saveBtn" class="btn primary" type="submit">Save Changes</button>
</div>
@endsection