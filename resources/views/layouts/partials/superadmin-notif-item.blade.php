@php
    $notifStyles = [
        'siswa'  => ['glyph' => '✓', 'box' => 'bg-emerald-100 text-emerald-600'],
        'admin'  => ['glyph' => '★', 'box' => 'bg-blue-100 text-blue-600'],
        'quiz'   => ['glyph' => '%', 'box' => 'bg-indigo-100 text-indigo-600'],
        'materi' => ['glyph' => '◆', 'box' => 'bg-amber-100 text-amber-600'],
    ];
    $notifStyle = $notifStyles[$item['type']] ?? ['glyph' => '•', 'box' => 'bg-slate-100 text-slate-500'];
@endphp
<div class="p-3.5 hover:bg-slate-50 transition flex gap-3 items-start">
    <div class="w-8 h-8 rounded-full {{ $notifStyle['box'] }} flex items-center justify-center shrink-0 text-xs font-bold">{{ $notifStyle['glyph'] }}</div>
    <div class="text-xs min-w-0">
        <p class="font-bold text-slate-700">{{ $item['title'] }}</p>
        <p class="text-slate-400 text-[11px]">{{ $item['desc'] }}</p>
        <p class="text-[10px] text-slate-300 font-semibold mt-1">{{ $item['time_label'] }}</p>
    </div>
</div>
