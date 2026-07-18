@extends('cms.layouts.master')

@section('title', 'Add Gallery')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Add Gallery</h2>
    </div>

    <div class="sectionBody">
                    @if (session('success'))
                <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
<form action="{{ route('galleries.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div style="color:red; margin-bottom:15px; margin-top:15px; background: #fff2f2; padding: 10px; border: 1px solid red; border-radius: 5px;">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="field">
                <label>Title</label>
                <input type="text" name="title"
                       value="{{ old('title') }}" required>
            </div>

            <div class="field">
                <label>Season</label>
                <input type="text" name="season"
                       value="{{ old('season') }}"
                       placeholder="Example: 2024/2025"
                       required>
            </div>

            <div class="field">
                <label>Upload Photos (Max 10)</label>
                <div>
                    <label class="btn-upload">
                        Choose Photos
                        <input type="file"
                               name="photos[]"
                               id="photo-input"
                               multiple
                               accept="image/*,.svg"
                               hidden
                               required>
                    </label>
                    <p id="photo-preview"></p>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    Save Gallery
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const input = document.getElementById("photo-input");
const preview = document.getElementById("photo-preview");
const dt = new DataTransfer(); // Holds the accumulated files

input.addEventListener("change", function(){
    // Append newly selected files to our DataTransfer object
    for (let i = 0; i < this.files.length; i++) {
        // Prevent exceeding 10 files
        if (dt.items.length >= 10) {
            alert("Maximum 10 photos allowed in total.");
            break;
        }
        
        // Avoid duplicate files by name (optional but helpful)
        let isDuplicate = false;
        for (let j = 0; j < dt.items.length; j++) {
            if (dt.items[j].getAsFile().name === this.files[i].name) {
                isDuplicate = true;
                break;
            }
        }
        if (!isDuplicate) {
            dt.items.add(this.files[i]);
        }
    }

    // Update the actual input files with the accumulated list
    this.files = dt.files;

    // Clear and render preview
    preview.innerHTML = "";
    Array.from(this.files).forEach((file, index) => {
        const p = document.createElement("p");
        p.style.display = "flex";
        p.style.alignItems = "center";
        p.style.gap = "10px";
        p.style.margin = "5px 0";
        
        const nameSpan = document.createElement("span");
        nameSpan.textContent = file.name;
        
        const removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.textContent = "❌";
        removeBtn.style.cursor = "pointer";
        removeBtn.style.border = "none";
        removeBtn.style.background = "none";
        removeBtn.style.fontSize = "12px";
        
        removeBtn.onclick = function() {
            dt.items.remove(index); // Remove from DataTransfer
            input.files = dt.files; // Sync with input
            
            // Re-trigger change to update preview (we temporarily disable the append logic when doing this)
            // Actually, we can just call the render part manually or just clear and render.
            // A simpler way: we just call a render function. But dispatchEvent is easier if we bypass the append.
            // Let's just manually re-render to avoid loop.
            renderPreview();
        };
        
        p.appendChild(nameSpan);
        p.appendChild(removeBtn);
        preview.appendChild(p);
    });

    function renderPreview() {
        preview.innerHTML = "";
        Array.from(input.files).forEach((f, idx) => {
            const p2 = document.createElement("p");
            p2.style.display = "flex";
            p2.style.alignItems = "center";
            p2.style.gap = "10px";
            p2.style.margin = "5px 0";
            
            const nSpan = document.createElement("span");
            nSpan.textContent = f.name;
            
            const rBtn = document.createElement("button");
            rBtn.type = "button";
            rBtn.textContent = "❌";
            rBtn.style.cursor = "pointer";
            rBtn.style.border = "none";
            rBtn.style.background = "none";
            rBtn.style.fontSize = "12px";
            
            rBtn.onclick = function() {
                dt.items.remove(idx);
                input.files = dt.files;
                renderPreview();
            };
            
            p2.appendChild(nSpan);
            p2.appendChild(rBtn);
            preview.appendChild(p2);
        });
    }
});
</script>

@endsection
