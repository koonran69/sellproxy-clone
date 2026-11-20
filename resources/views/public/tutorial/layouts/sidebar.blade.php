<aside id="blogSidebar" class="navbar navbar-vertical navbar-expand-lg">
    <div class="d-flex flex-column w-100 gap-2">
        <div class="sidebar-title">
            @lang('Chuyên mục')
        </div>
        <div class="sidebar-category navbar-collapse collapse">
            <ul class="navbar-nav">
                @foreach ($data as $cat)
                    
                    <li @class([
                        'nav-item',
                        'active' => isset($category) && $cat->id == $category->id,
                        'dropdown' => $cat->hasChildren()
                    ])>
                        <a @class([
                            'nav-link',
                            'dropdown-toggle' => $cat->hasChildren()
                        ]) href="{{ route('tutorial.category.show', $cat->slug) }}">
                            <span class="nav-link-title">
                                {{ $cat->getTranslate('name') }}
                            </span>
                        </a>
                        @if ($cat->hasChildren())
                            <div class="dropdown-menu show" data-bs-popper="static">
                                @foreach ($cat->children as $child)
                                    <a @class([
                                        'dropdown-item', 
                                        'active' => isset($category) && $child->id == $category->id
                                    ]) href="{{ route('tutorial.category.show', $child->slug) }}" rel="noopener">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</aside>