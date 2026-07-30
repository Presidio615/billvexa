@extends('layouts.admin')

@section('title', ucfirst($type).' Report')

@section('page-title', ucfirst($type).' Report')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h4>{{ ucfirst($type) }} Report</h4>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        @if($data->count())

                            @foreach(array_keys($data->first()->toArray()) as $column)

                                <th>{{ ucwords(str_replace('_',' ', $column)) }}</th>

                            @endforeach

                        @endif

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $row)

                        <tr>

                            @foreach($row->toArray() as $value)

                                <td>{{ $value }}</td>

                            @endforeach

                        </tr>

                    @empty

                        <tr>

                            <td colspan="100%" class="text-center">

                                No records found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection