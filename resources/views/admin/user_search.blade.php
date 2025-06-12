 @if ($users->isNotEmpty())
     @foreach ($users as $user)
         <tr>
             <th scope="row">{{ $loop->iteration }}</th>
             <td>{{ $user->name }}</td>
             <td>{{ $user->email }}</td>
             <td></td>
             <td>
                 {{ $user->investor == 1 ? 'Investor' : '' }}{{ $user->investor == 1 && $user->partner == 1 ? ' | ' : '' }}{{ $user->partner == 1 ? 'Partner' : '' }}
             </td>
             <td>{{ Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
             <td>
                 <span class="badge rounded-pill">
                     <a href="" type="button" title="Edit Property" class="btn btn-success edit-main-category">
                         <i class="ri-edit-box-line"></i>
                     </a>
                     <a href="" class="btn btn-danger" 
                         onclick="return confirm('Are you sure you want to delete this Property')">
                         <i class="ri-delete-bin-line"></i>
                     </a>
                 </span>
             </td>
         </tr>
     @endforeach
 @endif
