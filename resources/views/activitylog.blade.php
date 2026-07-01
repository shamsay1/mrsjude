<div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fa fa-users me-2"></i>
                            All loggings activity
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP ADDRESS</th>
                                    <th>Platform</th>
                                </tr>
                            </thead>


                            <tbody>
                                 @foreach ($activities as $a)
                                 <tr>
                                    <td>{{ $a->module }}</td>
                                    <td>{{ $a->action }}</td>
                                    <td>{{ $a->description }}</td>
                                    <td>{{ $a->ip_address }}</td>
                                    <td>{{ $a->platform }}</td>
                                 </tr>
                                 
                                     
                                 @endforeach
                                 <tr>
                                    <td colspan="100%" style="text-align: center"><a href="{{ route('all_logs') }}">View all</a></td>
                                 </tr>
                            </tbody>
                            
                        </table>
                    </div>