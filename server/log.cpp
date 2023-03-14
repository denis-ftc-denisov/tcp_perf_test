#include "log.h"
#include <chrono>
#include <iostream>

using namespace std;

void LogTime(const string &message)
{
#ifdef LOGGING_ENABLED
	static auto start = chrono::high_resolution_clock::now();
	static auto prev = start;
	auto current = chrono::high_resolution_clock::now();
	auto nsec = chrono::duration_cast<chrono::nanoseconds>(current - start).count();
	auto nsec_prev = chrono::duration_cast<chrono::nanoseconds>(current - prev).count();
	cerr << (nsec / 1000000.f) << " " << message << " delta " << (nsec_prev / 1000000.0f) << "\n";
	prev = current;
#endif
}
