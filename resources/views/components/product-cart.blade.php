@props(['name', 'price', 'quantity_available' => [],)

<div class="bg-white mb-4 p-4 border border-gray-200">
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-1/6">
            <div class="border border-gray-200 p-2">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-UMoZRw43BzXtkYbs7IkXIQT4Hoym4W.png" alt="{{ $name }}" class="w-full">
            </div>
        </div>
        <div class="w-full md:w-5/6 pl-0 md:pl-4 mt-4 md:mt-0">
            <div class="flex justify-between">
                <h3 class="text-lg font-semibold">{{ $name }}</h3>
                <span class="text-orange-500 font-bold">₹{{ $price }}</span>
            </div>
            <p class="text-sm text-gray-600 my-2">
                {{ $description }}
            </p>
            <div class="flex justify-between items-center mt-2">
                <div>
                    @foreach($tags as $tag)
                        <span class="bg-green-500 text-white text-xs px-2 py-1">{{ $tag }}</span>
                    @endforeach
                    
                    @foreach($extraInfo as $info)
                        <span class="text-xs block mt-1">{{ $info }}</span>
                    @endforeach
                </div>
                <button class="bg-orange-500 text-white px-6 py-1 uppercase">View</button>
            </div>
        </div>
    </div>
</div>

