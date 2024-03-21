<ul>
    @foreach($childs as $child)
        <li>
            {{ $child->name }}
        @if(count($child->childs))
                @include('general.standard.manageChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>