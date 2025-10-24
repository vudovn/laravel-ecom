<x-mail::message>
    # Xác nhận tài khoản {{ $nameVery }}!

    Để xác nhận tài khoản, vui lòng nhấn vào nút bên dưới.

    {{-- <x-mail::button :url="$url">
        Xác nhận tài khoản
    </x-mail::button> --}}
    {{ $url }}
</x-mail::message>
