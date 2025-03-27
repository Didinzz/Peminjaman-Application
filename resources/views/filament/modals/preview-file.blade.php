@props(['fileUrl', 'fileType'])

@if(in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']))
    <img src="{{ $fileUrl }}" class="w-full h-10vh rounded-lg">
@elseif($fileType === 'pdf')
    <iframe src="{{ $fileUrl }}" class="w-full h-[80vh]" frameborder="0"></iframe>
@else
    <p class="text-gray-600">File tidak dapat ditampilkan. <a href="{{ $fileUrl }}" class="text-blue-500 underline" target="_blank">Unduh File</a></p>
@endif
