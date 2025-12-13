<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogMonitorService
{
    /**
     * Log an action to the database
     *
     * @param string $action Action type (create, update, delete, view, login, logout, etc.)
     * @param string|null $description Human-readable description
     * @param Model|null $model The model instance that was affected
     * @param Request|null $request The HTTP request
     * @param array|null $requestData Additional request data to log
     * @param array|null $responseData Response data to log
     * @param string $status Status: success, error, warning
     * @param string|null $errorMessage Error message if status is error
     * @return Log
     */
    public function log(
        string $action,
        ?string $description = null,
        ?Model $model = null,
        ?Request $request = null,
        ?array $requestData = null,
        ?array $responseData = null,
        string $status = 'success',
        ?string $errorMessage = null
    ): Log {
        $user = Auth::user();
        $request = $request ?? request();
        
        $logData = [
            'user_id' => $user?->id,
            'action' => $action,
            'description' => $description ?? $this->generateDescription($action, $model),
            'status' => $status,
            'error_message' => $errorMessage,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'route' => $request->route()?->getName() ?? $request->path(),
            'method' => $request->method(),
        ];
        
        // Add model information if provided
        if ($model) {
            $logData['model_type'] = get_class($model);
            $logData['model_id'] = $model->id;
        }
        
        // Add request data
        if ($requestData !== null) {
            $logData['request_data'] = $requestData;
        } elseif ($request && in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            // Automatically log request data for write operations (excluding sensitive fields)
            $logData['request_data'] = $this->sanitizeRequestData($request->all());
        }
        
        // Add response data if provided
        if ($responseData !== null) {
            $logData['response_data'] = $responseData;
        }
        
        return Log::create($logData);
    }
    
    /**
     * Log a create action
     */
    public function logCreate(
        Model $model,
        ?string $description = null,
        ?Request $request = null,
        ?array $requestData = null
    ): Log {
        return $this->log(
            action: 'create',
            description: $description ?? "Created {$this->getModelName($model)}",
            model: $model,
            request: $request,
            requestData: $requestData
        );
    }
    
    /**
     * Log an update action
     */
    public function logUpdate(
        Model $model,
        ?string $description = null,
        ?Request $request = null,
        ?array $requestData = null
    ): Log {
        return $this->log(
            action: 'update',
            description: $description ?? "Updated {$this->getModelName($model)}",
            model: $model,
            request: $request,
            requestData: $requestData
        );
    }
    
    /**
     * Log a delete action
     */
    public function logDelete(
        Model $model,
        ?string $description = null,
        ?Request $request = null
    ): Log {
        return $this->log(
            action: 'delete',
            description: $description ?? "Deleted {$this->getModelName($model)}",
            model: $model,
            request: $request
        );
    }
    
    /**
     * Log a view action
     */
    public function logView(
        Model $model,
        ?string $description = null,
        ?Request $request = null
    ): Log {
        return $this->log(
            action: 'view',
            description: $description ?? "Viewed {$this->getModelName($model)}",
            model: $model,
            request: $request
        );
    }
    
    /**
     * Log a login action
     */
    public function logLogin(
        ?Model $user = null,
        ?string $description = null,
        ?Request $request = null,
        bool $success = true
    ): Log {
        $user = $user ?? Auth::user();
        
        return $this->log(
            action: 'login',
            description: $description ?? ($success ? "User logged in" : "Failed login attempt"),
            model: $user,
            request: $request,
            status: $success ? 'success' : 'error'
        );
    }
    
    /**
     * Log a logout action
     */
    public function logLogout(
        ?Model $user = null,
        ?string $description = null,
        ?Request $request = null
    ): Log {
        $user = $user ?? Auth::user();
        
        return $this->log(
            action: 'logout',
            description: $description ?? "User logged out",
            model: $user,
            request: $request
        );
    }
    
    /**
     * Log an error
     */
    public function logError(
        string $action,
        string $errorMessage,
        ?string $description = null,
        ?Model $model = null,
        ?Request $request = null,
        ?array $requestData = null
    ): Log {
        return $this->log(
            action: $action,
            description: $description,
            model: $model,
            request: $request,
            requestData: $requestData,
            status: 'error',
            errorMessage: $errorMessage
        );
    }
    
    /**
     * Log a custom action
     */
    public function logCustom(
        string $action,
        string $description,
        ?Model $model = null,
        ?Request $request = null,
        ?array $requestData = null,
        ?array $responseData = null,
        string $status = 'success'
    ): Log {
        return $this->log(
            action: $action,
            description: $description,
            model: $model,
            request: $request,
            requestData: $requestData,
            responseData: $responseData,
            status: $status
        );
    }
    
    /**
     * Get logs for a specific user
     */
    public function getLogsForUser(int $userId, int $limit = 50)
    {
        return Log::forUser($userId)
            ->latest()
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get logs for a specific model
     */
    public function getLogsForModel(string $modelType, ?int $modelId = null, int $limit = 50)
    {
        $query = Log::forModel($modelType, $modelId)
            ->latest()
            ->limit($limit);
        
        return $query->get();
    }
    
    /**
     * Get logs by action
     */
    public function getLogsByAction(string $action, int $limit = 50)
    {
        return Log::action($action)
            ->latest()
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get error logs
     */
    public function getErrorLogs(int $limit = 50)
    {
        return Log::status('error')
            ->latest()
            ->limit($limit)
            ->get();
    }
    
    /**
     * Generate a description based on action and model
     */
    protected function generateDescription(string $action, ?Model $model): string
    {
        if (!$model) {
            return ucfirst($action);
        }
        
        $modelName = $this->getModelName($model);
        return ucfirst($action) . " {$modelName}";
    }
    
    /**
     * Get a human-readable model name
     */
    protected function getModelName(Model $model): string
    {
        $className = class_basename(get_class($model));
        
        // Try to get a name attribute if available
        if (isset($model->name)) {
            return "{$className} ({$model->name})";
        }
        
        // Try to get a title attribute if available
        if (isset($model->title)) {
            return "{$className} ({$model->title})";
        }
        
        // Try to get a no_faktur or similar identifier
        if (isset($model->no_faktur)) {
            return "{$className} ({$model->no_faktur})";
        }
        
        return "{$className} #{$model->id}";
    }
    
    /**
     * Sanitize request data by removing sensitive fields
     */
    protected function sanitizeRequestData(array $data): array
    {
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'current_password',
            'new_password',
            'token',
            'api_key',
            'secret',
            '_token',
        ];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***REDACTED***';
            }
        }
        
        return $data;
    }
}
