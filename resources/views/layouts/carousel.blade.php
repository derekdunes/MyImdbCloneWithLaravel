    @foreach($headPost as $post)
      
      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark" style="background-image: url( {{ url( '/uploads/'. $post->image ) }} ); background-size: 100% 100%; height: 500px; width: 100%">
        <div class="col-md-6 px-0" style="padding-top:19%">
          <h1 class="display-4 font-italic">{{ $post->title }}</h1>
          <p class="lead my-3">{{ $post->body }}</p>
          <p class="lead mb-0"><a href="{{ url( '/posts/'. $post->id ) }}" class="text-white font-weight-bold">Continue reading...</a></p>
        </div>
      </div>
      @php
        break;
      @endphp
    @endforeach