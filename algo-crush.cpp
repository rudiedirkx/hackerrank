// https://www.hackerrank.com/challenges/crush

#include <cmath>
#include <cstdio>
#include <vector>
#include <iostream>
#include <algorithm>
using namespace std;

int main() {
    int iNums, iOps;
    cin >> iNums;
    cin >> iOps;

    // unsigned int numbers[iNums] = {0};
    std::vector<unsigned int> numbers(iNums);

    unsigned int iFrom, iTo, iAdd;
    for (int i = 0; i < iOps; i++) {
        cin >> iFrom;
        cin >> iTo;
        cin >> iAdd;

        for (int p = iFrom-1; p < iTo; p++) {
            numbers[p] += iAdd;
        }

        //cout << iFrom << " - " << iTo << " + " << iAdd << "\n";
    }

    unsigned int max = 0;
    for (int p = 0; p < iNums; p++) {
        if (max < numbers[p]) {
            max = numbers[p];
            //cout << "max = " << max << "\n";
        }
    }

    cout << max;

    return 0;
}
