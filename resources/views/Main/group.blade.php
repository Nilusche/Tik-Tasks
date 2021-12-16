@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="css/select.css">
@endsection

@section('content')
    <div class="container">
        <form action="/assignTags" method="POST">
            @csrf
            <div class="form-group">
                <select id="selecttag" class="form-control" name="tags[]" multiple>
                    @foreach ($tags as $tag)
                        @if ($tag->users_id == auth()->user()->id)
                            <option value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @endif
                    @endforeach
                </select>

            </div>
            <ul class="list-group">
                @foreach ($TaskUserPairs as $TaskUserPair)
                    @if ($TaskUserPair->users_id == auth()->user()->id)
                        @foreach ($tasks as $task)
                            @if ($task->completed == false && $task->id == $TaskUserPair->tasks_id && $TaskUserPair->isOwner!=0)
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" name="tasks[]" type="checkbox"
                                        value="{{ $task->id }}" aria-label="...">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h5>Titel: </h5>{{ $task->title }}
                                        </div>
                                        <div class="col-lg-4">
                                            <h5>Deadline: </h5>{{ $task->deadline }}
                                        </div>
                                        <div class="col-lg-4">
                                            <h5>Gruppen: </h5>
                                            @foreach ($tags as $tag)
                                                @if ($tag->users_id == auth()->user()->id)
                                                    @if ($task->hasTag($tag->id))
                                                        [{{ $tag->name }}]
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
            <button type="submit" class="btn btn-primary">Gruppieren</button>
        </form>
    </div>

@endsection

@section('bottomscripts')
    <script>
        $(document).ready(function() {

            var select = $('select[multiple]');
            var options = select.find('option');

            var div = $('<div />').addClass('selectMultiple');
            var active = $('<div />');
            var list = $('<ul />');
            var placeholder = select.data('placeholder');

            var span = $('<span />').text(placeholder).appendTo(active);

            options.each(function() {
                var text = $(this).text();
                if ($(this).is(':selected')) {
                    active.append($('<a />').html('<em>' + text + '</em><i></i>'));
                    span.addClass('hide');
                } else {
                    list.append($('<li />').html(text));
                }
            });

            active.append($('<div />').addClass('arrow'));
            div.append(active).append(list);

            select.wrap(div);

            $(document).on('click', '.selectMultiple ul li', function(e) {
                var select = $(this).parent().parent();
                var li = $(this);
                if (!select.hasClass('clicked')) {
                    select.addClass('clicked');
                    li.prev().addClass('beforeRemove');
                    li.next().addClass('afterRemove');
                    li.addClass('remove');
                    var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide()
                        .appendTo(select.children('div'));
                    a.slideDown(400, function() {
                        setTimeout(function() {
                            a.addClass('shown');
                            select.children('div').children('span').addClass('hide');
                            select.find('option:contains(' + li.text() + ')').prop(
                                'selected', true);
                        }, 500);
                    });
                    setTimeout(function() {
                        if (li.prev().is(':last-child')) {
                            li.prev().removeClass('beforeRemove');
                        }
                        if (li.next().is(':first-child')) {
                            li.next().removeClass('afterRemove');
                        }
                        setTimeout(function() {
                            li.prev().removeClass('beforeRemove');
                            li.next().removeClass('afterRemove');
                        }, 200);

                        li.slideUp(400, function() {
                            li.remove();
                            select.removeClass('clicked');
                        });
                    }, 600);
                }
            });

            $(document).on('click', '.selectMultiple > div a', function(e) {
                var select = $(this).parent().parent();
                var self = $(this);
                self.removeClass().addClass('remove');
                select.addClass('open');
                setTimeout(function() {
                    self.addClass('disappear');
                    setTimeout(function() {
                        self.animate({
                            width: 0,
                            height: 0,
                            padding: 0,
                            margin: 0
                        }, 300, function() {
                            var li = $('<li />').text(self.children('em').text())
                                .addClass('notShown').appendTo(select.find('ul'));
                            li.slideDown(400, function() {
                                li.addClass('show');
                                setTimeout(function() {
                                    select.find('option:contains(' +
                                        self.children('em')
                                        .text() + ')').prop(
                                        'selected', false);
                                    if (!select.find(
                                            'option:selected')
                                        .length) {
                                        select.children('div')
                                            .children('span')
                                            .removeClass('hide');
                                    }
                                    li.removeClass();
                                }, 400);
                            });
                            self.remove();
                        })
                    }, 300);
                }, 400);
            });

            $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
                $(this).parent().parent().toggleClass('open');
            });

        });
    </script>
@endsection
