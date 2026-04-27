<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardMemberResource;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class BoardMemberAdminController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => BoardMemberResource::collection(
                BoardMember::query()->orderBy('sort_order')->orderBy('name')->get()
            )
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
         ->header('Pragma', 'no-cache')
         ->header('Expires', '0');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_fr' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'role_fr' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'bio_fr' => ['nullable', 'string'],
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'linkedin_url' => ['nullable', 'string', 'max:500'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $member = BoardMember::query()->create($data);

        return response()->json([
            'data' => BoardMemberResource::make($member)
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
         ->header('Pragma', 'no-cache')
         ->header('Expires', '0');
    }

    public function show(BoardMember $boardMember): JsonResponse
    {
        return response()->json([
            'data' => BoardMemberResource::make($boardMember)
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
         ->header('Pragma', 'no-cache')
         ->header('Expires', '0');
    }

    public function update(Request $request, BoardMember $boardMember): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'name_fr' => ['nullable', 'string', 'max:255'],
            'role' => ['sometimes', 'required', 'string', 'max:255'],
            'role_fr' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'bio_fr' => ['nullable', 'string'],
            'email' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'linkedin_url' => ['nullable', 'string', 'max:500'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $boardMember->update($data);

        return response()->json([
            'data' => BoardMemberResource::make($boardMember->fresh())
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
         ->header('Pragma', 'no-cache')
         ->header('Expires', '0');
    }

    public function destroy(BoardMember $boardMember): JsonResponse
    {
        try {
            // Log the deletion attempt
            \Log::info('Deleting board member', [
                'id' => $boardMember->id,
                'name' => $boardMember->name,
                'email' => $boardMember->email
            ]);
            
            // Soft delete the board member (preserves data for recovery)
            $deleted = $boardMember->delete();
            
            if ($deleted) {
                \Log::info('Board member soft deleted successfully', [
                    'id' => $boardMember->id,
                    'deleted_at' => now()->toDateTimeString()
                ]);
                
                return response()->json([
                    'message' => 'Board member deleted successfully',
                    'id' => $boardMember->id,
                    'deleted_at' => now()->toDateTimeString()
                ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                 ->header('Pragma', 'no-cache')
                 ->header('Expires', '0');
            } else {
                \Log::error('Failed to delete board member', [
                    'id' => $boardMember->id
                ]);
                
                return response()->json([
                    'message' => 'Failed to delete board member'
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Exception while deleting board member', [
                'id' => $boardMember->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'An error occurred while deleting board member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Force delete a board member (permanent deletion)
     */
    public function forceDestroy(BoardMember $boardMember): JsonResponse
    {
        try {
            // Log the force deletion attempt
            \Log::info('Force deleting board member', [
                'id' => $boardMember->id,
                'name' => $boardMember->name,
                'email' => $boardMember->email
            ]);
            
            // Force delete the board member (permanent removal)
            $boardMember->forceDelete();
            
            \Log::info('Board member force deleted successfully', [
                'id' => $boardMember->id
            ]);
            
            return response()->json([
                'message' => 'Board member permanently deleted',
                'id' => $boardMember->id
            ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
             ->header('Pragma', 'no-cache')
             ->header('Expires', '0');
        } catch (\Exception $e) {
            \Log::error('Exception while force deleting board member', [
                'id' => $boardMember->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'An error occurred while permanently deleting board member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore a soft deleted board member
     */
    public function restore(BoardMember $boardMember): JsonResponse
    {
        try {
            // Log the restore attempt
            \Log::info('Restoring board member', [
                'id' => $boardMember->id,
                'name' => $boardMember->name
            ]);
            
            // Restore the soft deleted board member
            $boardMember->restore();
            
            \Log::info('Board member restored successfully', [
                'id' => $boardMember->id,
                'restored_at' => now()->toDateTimeString()
            ]);
            
            return response()->json([
                'message' => 'Board member restored successfully',
                'id' => $boardMember->id,
                'restored_at' => now()->toDateTimeString()
            ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
             ->header('Pragma', 'no-cache')
             ->header('Expires', '0');
        } catch (\Exception $e) {
            \Log::error('Exception while restoring board member', [
                'id' => $boardMember->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'An error occurred while restoring board member: ' . $e->getMessage()
            ], 500);
        }
    }
}
