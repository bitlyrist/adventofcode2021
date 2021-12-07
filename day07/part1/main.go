package main

import (
	"bufio"
	"fmt"
	"math"
	"os"
	"sort"
	"strconv"
	"strings"
)

func read_std_in() []int {
	s := bufio.NewScanner(os.Stdin)
	s.Scan()
	sinput := strings.Split(s.Text(), ",")
	iinput := make([]int, 0)
	for _, snum := range sinput {
		num, _ := strconv.Atoi(snum)
		iinput = append(iinput, num)
	}
	return (iinput)
}

func main() {

	crabs := read_std_in()
	// fmt.Println(crabs)

	sort.Ints(crabs)
	count_crabs := len(crabs)
	offset := 1
	if count_crabs%2 == 0 {
		offset = -1
	}
	count_crabs += offset
	floor_crab := crabs[int(math.Floor(float64(count_crabs)/2))]
	ceil_crab := crabs[int(math.Ceil(float64(count_crabs)/2))]
	floor_sum, ceil_sum := 0.0, 0.0
	for _, crab := range crabs {
		floor_sum += math.Abs(float64(crab - floor_crab))
		ceil_sum += math.Abs(float64(crab - ceil_crab))
	}

	fmt.Println("Minimum fuel usage is:", math.Min(floor_sum, ceil_sum))

}
