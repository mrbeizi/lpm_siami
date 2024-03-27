<ul>
    @foreach($childs as $child)
        <li>
            {{ $child->name }}
            <i class="bx bx-search bx-xs"></i>
            @if(count($child->childs))
                @include('lpm.doc-spmi.manageChild',['childs' => $child->childs]) 
            @endif
        </li>
    @endforeach
</ul>