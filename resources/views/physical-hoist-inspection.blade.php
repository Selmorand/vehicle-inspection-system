@extends('layouts.app')

@section('title', 'Physical Hoist Inspection - Final Assessment')

@section('content')
<div class="container-fluid px-4">
    <!-- Progress Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/inspection/visual" style="color: var(--primary-color);">Visual Inspection</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/body-panel" style="color: var(--primary-color);">Body Panel Assessment</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/specific-areas" style="color: var(--primary-color);">Specific Area Images</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/interior" style="color: var(--primary-color);">Interior Assessment</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/interior-images" style="color: var(--primary-color);">Interior Specific Images</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/service-booklet" style="color: var(--primary-color);">Service Booklet</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/tyres-rims" style="color: var(--primary-color);">Tyres & Rims Assessment</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/mechanical-report" style="color: var(--primary-color);">Mechanical Report</a></li>
                    <li class="breadcrumb-item"><a href="/inspection/engine-compartment" style="color: var(--primary-color);">Engine Compartment</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--primary-color); font-weight: 600;">Physical Hoist Inspection</li>
                </ol>
            </nav>
            <div class="text-center">
                <span class="badge bg-primary fs-6">Step 5 of 5 - Final Assessment</span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center mb-4">
        <h1 class="display-5 text-gradient mb-2">ALPHA Inspection</h1>
        <h2 class="h4">Physical Hoist Inspection</h2>
        <p class="text-muted">Complete under-vehicle assessment to finalize the inspection process</p>
    </div>

    <form id="physicalHoistForm">
        @csrf
        
        <!-- Category 1: Suspension System Assessment -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Suspension System Assessment</h5>
                        <small class="text-light">11 Components - Shock absorbers, mounts, and control arms</small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="suspensionAssessmentTable">
                                <thead style="background-color: #b8dae0;">
                                    <tr>
                                        <th style="width: 25%;" class="text-center">Component</th>
                                        <th style="width: 20%;" class="text-center">Primary Condition</th>
                                        <th style="width: 20%;" class="text-center">Secondary Condition</th>
                                        <th style="width: 35%;" class="text-center">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Shock Absorbers & Leaks -->
                                    <tr class="component-row" data-category="suspension" data-component="lf_shock_leaks">
                                        <td class="component-name">LF Shock leaks</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[lf_shock_leaks][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[lf_shock_leaks][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[lf_shock_leaks][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="rf_shock_leaks">
                                        <td class="component-name">RF Shock leaks</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[rf_shock_leaks][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[rf_shock_leaks][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[rf_shock_leaks][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="lr_shock_leaks">
                                        <td class="component-name">LR Shock leaks</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[lr_shock_leaks][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[lr_shock_leaks][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[lr_shock_leaks][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="rr_shock_leaks">
                                        <td class="component-name">RR Shock leaks</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[rr_shock_leaks][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[rr_shock_leaks][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[rr_shock_leaks][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- Shock Mounts -->
                                    <tr class="component-row" data-category="suspension" data-component="lf_shock_mounts">
                                        <td class="component-name">LF Shock mounts</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[lf_shock_mounts][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[lf_shock_mounts][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[lf_shock_mounts][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="rf_shock_mounts">
                                        <td class="component-name">RF Shock mounts</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[rf_shock_mounts][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[rf_shock_mounts][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[rf_shock_mounts][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="lr_shock_mounts">
                                        <td class="component-name">LR Shock mounts</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[lr_shock_mounts][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[lr_shock_mounts][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[lr_shock_mounts][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="rr_shock_mounts">
                                        <td class="component-name">RR Shock mounts</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[rr_shock_mounts][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[rr_shock_mounts][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[rr_shock_mounts][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <!-- Control Arms -->
                                    <tr class="component-row" data-category="suspension" data-component="lf_control_arm_cracks">
                                        <td class="component-name">LF Control arm cracks</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[lf_control_arm_cracks][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[lf_control_arm_cracks][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[lf_control_arm_cracks][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="rf_control_arm_cracks">
                                        <td class="component-name">RF Control arm cracks</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[rf_control_arm_cracks][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[rf_control_arm_cracks][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[rf_control_arm_cracks][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="lf_control_arm_play">
                                        <td class="component-name">LF control arm play</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[lf_control_arm_play][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[lf_control_arm_play][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[lf_control_arm_play][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="suspension" data-component="rf_control_arm_play">
                                        <td class="component-name">RF control arm play</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="suspension[rf_control_arm_play][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="suspension[rf_control_arm_play][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="suspension[rf_control_arm_play][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category 2: Engine System Assessment -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Engine System Assessment</h5>
                        <small class="text-light">10 Components - Engine mounting, oil levels, gearbox, and seals</small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="engineAssessmentTable">
                                <thead style="background-color: #b8dae0;">
                                    <tr>
                                        <th style="width: 25%;" class="text-center">Component</th>
                                        <th style="width: 20%;" class="text-center">Primary Condition</th>
                                        <th style="width: 20%;" class="text-center">Secondary Condition</th>
                                        <th style="width: 35%;" class="text-center">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="component-row" data-category="engine" data-component="engine_mountings">
                                        <td class="component-name">Engine mountings</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[engine_mountings][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[engine_mountings][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[engine_mountings][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="engine_oil_viscosity">
                                        <td class="component-name">Engine oil viscosity</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[engine_oil_viscosity][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[engine_oil_viscosity][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[engine_oil_viscosity][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="engine_oil_level">
                                        <td class="component-name">Engine oil level</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[engine_oil_level][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[engine_oil_level][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[engine_oil_level][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="gearbox_mountings">
                                        <td class="component-name">Gearbox mountings</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[gearbox_mountings][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[gearbox_mountings][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[gearbox_mountings][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="gearbox_oil_viscosity">
                                        <td class="component-name">Gearbox oil viscosity</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[gearbox_oil_viscosity][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[gearbox_oil_viscosity][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[gearbox_oil_viscosity][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="gearbox_oil_level">
                                        <td class="component-name">Gearbox oil level</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[gearbox_oil_level][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[gearbox_oil_level][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[gearbox_oil_level][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="timing_cover">
                                        <td class="component-name">Timing cover</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[timing_cover][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[timing_cover][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[timing_cover][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="sump">
                                        <td class="component-name">Sump</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[sump][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[sump][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[sump][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="side_shafts">
                                        <td class="component-name">Side shafts</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[side_shafts][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[side_shafts][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[side_shafts][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="front_main_seal">
                                        <td class="component-name">Front main seal</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[front_main_seal][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[front_main_seal][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[front_main_seal][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="engine" data-component="rear_main_seal">
                                        <td class="component-name">Rear main seal</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="engine[rear_main_seal][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="engine[rear_main_seal][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="engine[rear_main_seal][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category 3: Drivetrain System Assessment -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">Drivetrain System Assessment</h5>
                        <small class="text-light">6 Components - CV joints, propshaft, and differential</small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="drivetrainAssessmentTable">
                                <thead style="background-color: #b8dae0;">
                                    <tr>
                                        <th style="width: 25%;" class="text-center">Component</th>
                                        <th style="width: 20%;" class="text-center">Primary Condition</th>
                                        <th style="width: 20%;" class="text-center">Secondary Condition</th>
                                        <th style="width: 35%;" class="text-center">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="component-row" data-category="drivetrain" data-component="lf_cv_joint">
                                        <td class="component-name">LF CV joint</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="drivetrain[lf_cv_joint][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="drivetrain[lf_cv_joint][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="drivetrain[lf_cv_joint][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="drivetrain" data-component="rf_cv_joint">
                                        <td class="component-name">RF CV joint</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="drivetrain[rf_cv_joint][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="drivetrain[rf_cv_joint][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="drivetrain[rf_cv_joint][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="drivetrain" data-component="propshaft">
                                        <td class="component-name">Propshaft</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="drivetrain[propshaft][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="drivetrain[propshaft][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="drivetrain[propshaft][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="drivetrain" data-component="centre_bearing">
                                        <td class="component-name">Centre Bearing</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="drivetrain[centre_bearing][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="drivetrain[centre_bearing][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="drivetrain[centre_bearing][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="drivetrain" data-component="differential_mounting">
                                        <td class="component-name">Differential mounting</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="drivetrain[differential_mounting][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="drivetrain[differential_mounting][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="drivetrain[differential_mounting][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>

                                    <tr class="component-row" data-category="drivetrain" data-component="differential_oil">
                                        <td class="component-name">Differential oil</td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown primary-condition" 
                                                    name="drivetrain[differential_oil][primary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="condition-cell">
                                            <select class="form-control condition-dropdown secondary-condition" 
                                                    name="drivetrain[differential_oil][secondary_condition]">
                                                <option value="">Select...</option>
                                                <option value="Good">Good</option>
                                                <option value="Average">Average</option>
                                                <option value="Bad">Bad</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </td>
                                        <td class="comments-cell">
                                            <textarea class="form-control component-comments" 
                                                      name="drivetrain[differential_oil][comments]" 
                                                      rows="1" placeholder="Add comments..."></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-outline-secondary me-3" id="backBtn">
                    <i class="bi bi-arrow-left me-1"></i>Back to Engine Compartment
                </button>
                <button type="button" class="btn btn-secondary me-3" id="saveDraftBtn">Save Draft</button>
                <button type="submit" class="btn btn-success" id="completeInspectionBtn" form="physicalHoistForm">
                    <i class="bi bi-check-circle me-1"></i>Complete Inspection
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('additional-css')
<style>
/* Physical Hoist Inspection Styling */
.component-name {
    font-weight: 500;
    background-color: #f8f9fa;
}

/* Condition Dropdown Color Coding */
.condition-dropdown.condition-good {
    background-color: #28a745;
    color: white;
    border-color: #28a745;
}

.condition-dropdown.condition-average {
    background-color: #ffc107;
    color: black;
    border-color: #ffc107;
}

.condition-dropdown.condition-bad {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}

.condition-dropdown.condition-na {
    background-color: #6c757d;
    color: white;
    border-color: #6c757d;
}

/* Comments field styling */
.component-comments {
    transition: all 0.3s ease;
    min-height: 38px;
    resize: vertical;
}

.component-comments.required {
    border-color: #dc3545;
    background-color: #fff5f5;
}

.component-comments:focus {
    box-shadow: 0 0 0 0.2rem rgba(79, 149, 155, 0.25);
    border-color: var(--primary-color);
}

/* Responsive design */
@media (max-width: 991px) {
    .table-responsive {
        font-size: 14px;
    }
}

@media (max-width: 768px) {
    .table {
        font-size: 12px;
    }
}
</style>
@endsection

@section('additional-js')
<script>
// Physical hoist inspection data storage
let physicalHoistData = {
    suspension: {},
    engine: {},
    drivetrain: {}
};

let totalComponents = 27; // 11 suspension + 10 engine + 6 drivetrain

document.addEventListener('DOMContentLoaded', function() {
    // Load previous inspection data if available
    loadPreviousData();
    
    // Initialize condition dropdowns
    initializeConditionDropdowns();

    // Form submission handler
    document.getElementById('physicalHoistForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Save the data and complete inspection
        saveCurrentProgress();
        
        // Show completion message
        alert('Vehicle inspection completed successfully! All data has been saved.');
        
        // Redirect to dashboard
        window.location.href = '/dashboard';
    });

    // Navigation button handlers
    document.getElementById('backBtn').addEventListener('click', function() {
        saveCurrentProgress();
        window.location.href = '/inspection/engine-compartment';
    });

    document.getElementById('saveDraftBtn').addEventListener('click', function() {
        saveCurrentProgress();
        alert('Physical hoist inspection draft saved successfully!');
    });
});

function initializeConditionDropdowns() {
    const conditionDropdowns = document.querySelectorAll('.condition-dropdown');
    
    conditionDropdowns.forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const row = this.closest('.component-row');
            const category = row.dataset.category;
            const component = row.dataset.component;
            const conditionType = this.classList.contains('primary-condition') ? 'primary' : 'secondary';
            const condition = this.value;
            const commentsField = row.querySelector('.component-comments');
            
            // Update dropdown styling
            updateConditionStyling(this, condition);
            
            // Handle comments field requirements
            handleCommentsField(commentsField, condition, row);
            
            // Store the assessment data
            if (!physicalHoistData[category][component]) {
                physicalHoistData[category][component] = {
                    primary_condition: '',
                    secondary_condition: '',
                    comments: ''
                };
            }
            
            physicalHoistData[category][component][conditionType + '_condition'] = condition;
        });
    });
    
    // Add listeners to comments fields
    const commentsFields = document.querySelectorAll('.component-comments');
    commentsFields.forEach(field => {
        field.addEventListener('input', function() {
            const row = this.closest('.component-row');
            const category = row.dataset.category;
            const component = row.dataset.component;
            
            if (!physicalHoistData[category][component]) {
                physicalHoistData[category][component] = {
                    primary_condition: '',
                    secondary_condition: '',
                    comments: ''
                };
            }
            
            physicalHoistData[category][component].comments = this.value;
        });
    });
}

function updateConditionStyling(dropdown, condition) {
    // Remove all condition classes
    dropdown.classList.remove('condition-good', 'condition-average', 'condition-bad', 'condition-na');
    
    // Add appropriate class based on condition
    if (condition === 'Good') {
        dropdown.classList.add('condition-good');
    } else if (condition === 'Average') {
        dropdown.classList.add('condition-average');
    } else if (condition === 'Bad') {
        dropdown.classList.add('condition-bad');
    } else if (condition === 'N/A') {
        dropdown.classList.add('condition-na');
    }
}

function handleCommentsField(commentsField, condition, row) {
    // Check if either primary or secondary condition is Bad
    const primaryCondition = row.querySelector('.primary-condition').value;
    const secondaryCondition = row.querySelector('.secondary-condition').value;
    
    if (primaryCondition === 'Bad' || secondaryCondition === 'Bad') {
        commentsField.classList.add('required');
        commentsField.setAttribute('placeholder', 'Comments required for Bad condition...');
        commentsField.focus();
    } else if (primaryCondition === 'Average' || secondaryCondition === 'Average') {
        commentsField.classList.remove('required');
        commentsField.setAttribute('placeholder', 'Add comments if needed...');
    } else {
        commentsField.classList.remove('required');
        commentsField.setAttribute('placeholder', 'Add comments...');
    }
    
    // Check for mismatched conditions
    if (primaryCondition && secondaryCondition && primaryCondition !== secondaryCondition) {
        if (!commentsField.value.includes('mismatched conditions')) {
            commentsField.setAttribute('placeholder', 'Note: Different primary/secondary conditions detected...');
        }
    }
}

function loadPreviousData() {
    const visualData = sessionStorage.getItem('visualInspectionData');
    if (visualData) {
        const data = JSON.parse(visualData);
        displayInspectionSummary(data);
    }
    
    // Load existing physical hoist data if available
    const hoistData = sessionStorage.getItem('physicalHoistData');
    if (hoistData) {
        restorePhysicalHoistData(JSON.parse(hoistData));
    }
}

function displayInspectionSummary(data) {
    const breadcrumbContainer = document.querySelector('.breadcrumb').parentElement.parentElement;
    const summaryDiv = document.createElement('div');
    summaryDiv.className = 'row mb-3';
    summaryDiv.innerHTML = `
        <div class="col-12">
            <div class="alert alert-info">
                <strong>Final Inspection Summary:</strong>
                ${data.manufacturer} ${data.model} (${data.vehicle_type}) | 
                VIN: ${data.vin} | 
                Inspector: ${data.inspector_name} |
                Progress: Visual ✓ | Body Panels ✓ | Specific Areas ✓ | Interior ✓ | Service Booklet ✓ | Tyres & Rims ✓ | Mechanical Report ✓ | Engine Compartment ✓ | <strong>Final Assessment</strong>
            </div>
        </div>
    `;
    breadcrumbContainer.parentNode.insertBefore(summaryDiv, breadcrumbContainer.nextSibling);
}

function saveCurrentProgress() {
    const formData = new FormData(document.getElementById('physicalHoistForm'));
    const updatedData = { ...physicalHoistData };
    
    // Update data with current form values
    sessionStorage.setItem('physicalHoistData', JSON.stringify(updatedData));
}

function restorePhysicalHoistData(data) {
    physicalHoistData = data;
    
    // Restore dropdowns and comments
    Object.keys(data).forEach(category => {
        Object.keys(data[category]).forEach(component => {
            const componentData = data[category][component];
            const row = document.querySelector(`[data-category="${category}"][data-component="${component}"]`);
            
            if (row) {
                // Restore primary condition
                const primarySelect = row.querySelector('.primary-condition');
                if (primarySelect && componentData.primary_condition) {
                    primarySelect.value = componentData.primary_condition;
                    updateConditionStyling(primarySelect, componentData.primary_condition);
                }
                
                // Restore secondary condition
                const secondarySelect = row.querySelector('.secondary-condition');
                if (secondarySelect && componentData.secondary_condition) {
                    secondarySelect.value = componentData.secondary_condition;
                    updateConditionStyling(secondarySelect, componentData.secondary_condition);
                }
                
                // Restore comments
                const commentsField = row.querySelector('.component-comments');
                if (commentsField && componentData.comments) {
                    commentsField.value = componentData.comments;
                }
                
                // Update comments field styling
                handleCommentsField(commentsField, componentData.primary_condition, row);
            }
        });
    });
}
</script>
@endsection