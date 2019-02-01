                    <table class="table table-hover">
                        <tbody >
                        <tr>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fname }} {{ $user->lname }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                       @endforeach
                       </tbody>
                    </table>