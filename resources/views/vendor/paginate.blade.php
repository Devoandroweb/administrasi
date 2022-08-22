@if ($paginator->hasPages())
    
    <ul class="pagination ml-auto" style="width: max-content;">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
        @endif


      
        @foreach ($elements as $element)
           
        
            @if (is_string($element))
                <li class="page-item disabled"><a class="page-link" href="#">{{ $element }}</a></li>
            @endif

            @if($paginator->currentPage() > 3)
            <li class="page-item "><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @endif

            @if($paginator->currentPage() > 4)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach
        
        @endforeach

        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif
        
        @if ($paginator->hasMorePages())

            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
        @endif
    </ul>

@endif


    
    
    
    
    
    