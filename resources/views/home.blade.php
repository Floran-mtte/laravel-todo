@extends('layouts.app')

@extends(Auth::user() ? 'task' : 'welcome')
