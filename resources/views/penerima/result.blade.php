@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Penerima</h2>
    <p><strong>Nama:</strong> {{ $penerima['nama_lengkap'] }}</p>
    <p><strong>Sekolah:</strong> {{ $penerima['nama_sekolah'] }}</p>

    <form id="checklistForm">
        <h4>Checklist Bantuan</h4>
        <label><input type="checkbox" class="item-check"> Tas</label><br>
        <label><input type="checkbox" class="item-check"> Sepatu</label><br>
        <label><input type="checkbox" class="item-check"> Seragam</label><br>
        <label><input type="checkbox" class="item-check"> Alat Tulis</label><br>
    </form>

    <button id="exportBtn" disabled>
        Export PDF
    </button>
</div>

<script>
    const checkboxes = document.querySelectorAll('.item-check');
    const exportBtn = document.getElementById('exportBtn');

    function updateButtonState() {
        const allChecked = [...checkboxes].every(checkbox => checkbox.checked);
        exportBtn.disabled = !allChecked;
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateButtonState));

    exportBtn.addEventListener('click', function () {
        const checkedItems = {};
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const label = cb.parentElement.textContent.trim();
                checkedItems[label] = true;
            }
        });

        fetch("{{ route('export.pdf', ['kode' => $penerima['kode_unik']]) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify(checkedItems)
        })
        .then(response => response.blob())
        .then(blob => {
            const fileURL = URL.createObjectURL(blob);
            const newWindow = window.open(fileURL);
            newWindow.onload = () => newWindow.print();
        });
    });
</script>
@endsection
