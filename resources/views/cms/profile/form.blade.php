<form action="{{ isset($club) ? route('club.update',$club) : route('club.store') }}"
      method="POST">
    @csrf
    @if(isset($club)) @method('PUT') @endif

    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @foreach([
        'name' => 'Name',
        'city' => 'City',
        'director_club' => 'Direktur Klub',
        'administrator' => 'Administrator',
        'technical_director' => 'Direktur Teknik',
        'training_venue' => 'Venue Latihan',
        'email' => 'Email',
        'contact_person' => 'Contact Person',
        'website' => 'Website',
        'founded_year' => 'Founded Year',
    ] as $field => $label)

        <div class="field">
            <label>{{ $label }}</label>
            <input type="text"
                   name="{{ $field }}"
                   value="{{ old($field, $club->$field ?? '') }}">
        </div>

    @endforeach

    <div class="field">
        <label>Status</label>
        <select name="status">
            <option value="member" {{ old('status', $club->status ?? '')=='member'?'selected':'' }}>Member</option>
            <option value="guest" {{ old('status', $club->status ?? '')=='guest'?'selected':'' }}>Guest</option>
        </select>
    </div>

    <div class="actions">
        <button type="submit" class="btn primary">
            {{ isset($club) ? 'Update Club' : 'Save Club' }}
        </button>
    </div>
</form>