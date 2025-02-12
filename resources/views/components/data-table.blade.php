<div class="bg-gray-800 bg-opacity-50 backdrop-blur-md rounded-lg shadow-lg p-6 border border-gray-700">
    <h3 class="text-xl font-semibold text-cyan-400 mb-4">{{ $title }}</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 border-b border-gray-700">
                    @foreach($columns as $column)
                        <th class="pb-3 font-semibold">{{ $column['header'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr class="border-b border-gray-700">
                        @foreach($columns as $column)
                            <td class="py-3 text-gray-300">
                                @if(isset($column['format']))
                                    @if($column['format'] === 'currency')
                                        Rp. {{ number_format($row->{$column['accessor']}, 2) }}
                                    @elseif($column['format'] === 'date')
                                        {{ $row->{$column['accessor']} ? \Carbon\Carbon::parse($row->{$column['accessor']})->format('M d, Y') : 'N/A' }}
                                    @elseif($column['format'] === 'datetime')
                                        {{ $row->{$column['accessor']} ? \Carbon\Carbon::parse($row->{$column['accessor']})->format('M d, Y H:i') : 'N/A' }}                                    
                                    @elseif($column['format'] === 'status')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if($row->{$column['accessor']} === 'completed') bg-green-500 text-green-100
                                            @elseif($row->{$column['accessor']} === 'pending') bg-yellow-500 text-yellow-100
                                            @else bg-red-500 text-red-100 @endif">
                                            {{ ucfirst($row->{$column['accessor']}) }}
                                        </span>
                                    @endif
                                @else
                                    {{ $row->{$column['accessor']} }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="mt-4 text-right">
        <a href="{{ route($link['route']) }}" class="text-cyan-400 hover:text-cyan-300">{{ $link['text'] }} →</a>
    </div> --}}
</div>
