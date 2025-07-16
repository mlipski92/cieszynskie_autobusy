<div>
    <div><h1>Kup bilet</h1></div>
    <div><h2>Linia <strong>{{ $lineName }}</strong></h2></div>
    <div class="">
        <div>Autobus z <strong>{{ $locationFrom }}, godz. {{ $timeFrom }}</strong> do <strong>{{ $locationTo }}, godz. {{ $timeTo }}</strong></div>
    </div>
    <div class="bg-[#b5b5b5]">
        <form action="/checkout" method="POST">
            @csrf
            <label class="block">
                <span>Imię i nazwisko: </span>
                <input type="text" name="name" />
            </label><br />
            <label class="block">
                <span>E-mail: </span>
                <input type="text" name="email" />
            </label><br />

            <input type="hidden" name="timeFrom" value="{{ $timeFrom }}">
            <input type="hidden" name="timeTo" value="{{ $timeTo }}">
            <input type="hidden" name="locationFrom" value="{{ $locationFrom }}">
            <input type="hidden" name="locationTo" value="{{ $locationTo }}">
            <input type="hidden" name="totalCost" value="{{ $totalCost }}">
            <input type="hidden" name="lineName" value="{{ $lineName }}">
            <input type="submit" value="KUP BILET" />
        </form>
    </div>
</div>

