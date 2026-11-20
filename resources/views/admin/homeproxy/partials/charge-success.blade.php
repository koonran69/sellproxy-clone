<div class="modal-body">
    <div class="text-center fw-bold">
        <img src="{{ $qrcode }}" alt="" width="250px" />
        <div class="fs-4 my-3">{{ $bank_name }}</div>
        <p class="">CTK: {{ $acc_name }}</p>
        <p class="">STK: {{ $acc_number }}</p>
        <p class="">Số tiền: {{ format_price($amount) }}</p>
        <p class="">Nội dung: {{ $desc }}</p>
    </div>
</div>