@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Wab Logs</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Wab Logs
                             <a class="pull-right" href="{{ route('chatLogs.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                             @include('chat_logs.table')
                         </div>

                         <div class="card-footer clearfix">
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                            <div class="flex justify-between flex-1 sm:hidden">
                                @if ($chatLogs->currentPage() > 1)
                                    <a href="{{ $chatLogs->url($chatLogs->currentPage() - 1) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        « Previous
                                    </a>
                                @endif
                                
                                @if ($chatLogs->hasMorePages())
                                    <a href="{{ $chatLogs->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        Next »
                                    </a>
                                @endif
                            </div>
                            </nav>
                        </div>
                        
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

